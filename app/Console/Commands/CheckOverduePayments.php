<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckOverduePayments extends Command
{
    protected $signature = 'payments:check-overdue';
    protected $description = 'Verifica y marca los pagos de los clientes como vencidos si no han pagado a tiempo.';

    public function handle()
    {
        $this->info('Iniciando verificación de pagos vencidos...');

        // Obtenemos todos los clientes con un servicio activo
        $clients = User::whereHas('services', function ($query) {
            $query->where('service_user.status', 'active');
        })->where('role_id', '!=', 1)->get();

        foreach ($clients as $client) {
            $assignment = DB::table('service_user')
                ->where('user_id', $client->id)
                ->where('status', 'active')
                ->first();

            if (!$assignment) continue;

            $startDate = Carbon::parse($assignment->start_date);
            $billingDay = $startDate->day;
            $today = Carbon::today();

            // Determina la fecha de vencimiento del mes actual
            $dueDateThisMonth = Carbon::now()->setDay($billingDay);
            if ($today->day > $billingDay) {
                // Si ya pasó el día de facturación de este mes, el ciclo actual es el del mes que viene
                // por lo que el ciclo a revisar es el de este mes.
            } else {
                // Si aún no es el día de facturación, el ciclo a revisar es el del mes pasado.
                $dueDateThisMonth->subMonth();
            }
            
            $monthToCheck = $dueDateThisMonth->format('Y-m');

            // Comprueba si ya existe un pago (pagado o pendiente) para el mes actual
            $hasPaidOrPending = $client->payments()
                ->where('month_paid', $monthToCheck)
                ->whereIn('status', ['paid', 'approved', 'pending'])
                ->exists();

            // Si ya pagó o tiene un pago pendiente, no hacemos nada.
            if ($hasPaidOrPending) {
                continue;
            }

            // Comprueba si han pasado más de 5 días desde la fecha de vencimiento
            $daysOverdue = $today->diffInDays($dueDateThisMonth, false);
            if ($daysOverdue < -5) {
                // Si no ha pagado y está en mora, creamos o actualizamos su registro de pago
                Payment::updateOrCreate(
                    [
                        'user_id' => $client->id,
                        'month_paid' => $monthToCheck,
                    ],
                    [
                        'amount' => $client->services()->first()->price, // Asigna el precio del plan
                        'payment_date' => $dueDateThisMonth->toDateString(),
                        'status' => 'overdue',
                    ]
                );
                $this->warn("Usuario #{$client->id} ({$client->first_name}) marcado como moroso para el mes {$monthToCheck}.");
            }
        }

        $this->info('Verificación de pagos vencidos completada.');
        return 0;
    }
}
