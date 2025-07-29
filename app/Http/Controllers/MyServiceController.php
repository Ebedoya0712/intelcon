<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MyServiceController extends Controller
{
    /**
     * Muestra la información del servicio activo del cliente.
     */
    public function show()
    {
        $user = Auth::user();

        // Busca la asignación de servicio activa del usuario
        $activeServiceAssignment = DB::table('service_user')
            ->join('services', 'service_user.service_id', '=', 'services.id')
            ->where('service_user.user_id', $user->id)
            ->where('service_user.status', 'active')
            ->select('services.name', 'services.speed_mbps', 'services.price', 'service_user.start_date')
            ->first();

        $paymentData = null;

        if ($activeServiceAssignment) {
            // Lógica para calcular la próxima fecha de pago
            $startDate = Carbon::parse($activeServiceAssignment->start_date);
            $today = Carbon::today();
            
            // El día del mes en que se debe pagar (ej: 15)
            $billingDay = $startDate->day;

            // Calcula la fecha de vencimiento para el mes actual
            $currentMonthDueDate = Carbon::now()->setDay($billingDay);

            // Si la fecha de vencimiento de este mes ya pasó, la próxima es el mes que viene
            if ($today->gt($currentMonthDueDate)) {
                $nextDueDate = $currentMonthDueDate->addMonth();
            } else {
                $nextDueDate = $currentMonthDueDate;
            }

            // Calcula los días restantes (diferencia entre hoy y la fecha de vencimiento)
            $daysRemaining = $today->diffInDays($nextDueDate, false); // false para obtener un valor negativo si ya pasó

            // Determina el estado del pago
            $paymentStatus = '';
            $statusClass = '';
            if ($daysRemaining > 5) {
                $paymentStatus = 'Al día';
                $statusClass = 'success';
            } elseif ($daysRemaining >= 0) {
                $paymentStatus = 'Próximo a Vencer';
                $statusClass = 'warning';
            } else {
                $paymentStatus = 'Vencido';
                $statusClass = 'danger';
                // Si han pasado más de 5 días, se considera moroso
                if ($daysRemaining < -5) {
                    $paymentStatus = 'En Mora (Contactar Soporte)';
                }
            }
            
            $paymentData = [
                'nextDueDate' => $nextDueDate,
                'daysRemaining' => $daysRemaining,
                'paymentStatus' => $paymentStatus,
                'statusClass' => $statusClass,
            ];
        }

        return view('my-service.show', [
            'activeService' => $activeServiceAssignment,
            'paymentData' => $paymentData,
        ]);
    }
}
