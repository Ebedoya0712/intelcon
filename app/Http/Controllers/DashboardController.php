<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard correspondiente al rol del usuario.
     */
    public function index()
    {
        $user = Auth::user();

        // Si es Administrador, muestra las estadísticas generales.
        if ($user->role_id == 1) {
            
            $totalClients = User::where('role_id', '!=', 1)->count();
            $totalServices = Service::count();
            $totalRevenue = Payment::whereIn('status', ['paid', 'approved'])->sum('amount');
            $pendingPaymentsCount = Payment::where('status', 'pending')->count();
            
            $recentUsers = User::where('role_id', '!=', 1)->latest()->take(5)->get();
            $recentPayments = Payment::with('user')->latest()->take(5)->get();

            return view('dashboard.admin', compact(
                'totalClients',
                'totalServices',
                'totalRevenue',
                'pendingPaymentsCount',
                'recentUsers',
                'recentPayments'
            ));

        } else {
            // Si es Cliente, muestra sus estadísticas personales.
            
            $totalPaid = $user->payments()->whereIn('status', ['paid', 'approved'])->sum('amount');
            $pendingClientPayments = $user->payments()->where('status', 'pending')->count();
            $overdueClientPayments = $user->payments()->where('status', 'overdue')->count();
            
            // Obtiene el servicio activo del cliente desde la tabla pivote
            $activeService = DB::table('service_user')
                ->join('services', 'service_user.service_id', '=', 'services.id')
                ->where('service_user.user_id', $user->id)
                ->where('service_user.status', 'active')
                ->select('services.name', 'services.speed_mbps', 'services.price', 'service_user.start_date')
                ->first();

            return view('dashboard.client', compact(
                'totalPaid',
                'pendingClientPayments',
                'overdueClientPayments',
                'activeService'
            ));
        }
    }
}
