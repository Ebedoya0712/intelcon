@extends('layouts.app')

@section('title', 'Dashboard del Administrador')

@section('content')
<!-- Encabezado de Página -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container-fluid">
    <!-- Cajas de Estadísticas -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalClients }}</h3>
                    <p>Clientes Registrados</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ route('users.index') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($totalRevenue, 2) }}</h3>
                    <p>Ingresos Totales</p>
                </div>
                <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                <a href="{{ route('payments.paid') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendingPaymentsCount }}</h3>
                    <p>Pagos Pendientes</p>
                </div>
                <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                <a href="{{ route('payments.pending') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalServices }}</h3>
                    <p>Planes de Servicio</p>
                </div>
                <div class="icon"><i class="fas fa-wifi"></i></div>
                <a href="{{ route('services.index') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Últimos Clientes Registrados</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr><th>ID</th><th>Nombre</th><th>Email</th></tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td><a href="{{ route('users.show', $user->id) }}">{{ $user->id }}</a></td>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Últimos Pagos Registrados</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr><th>ID Pago</th><th>Cliente</th><th>Monto</th><th>Estado</th></tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayments as $payment)
                                <tr>
                                    <td><a href="{{ route('payments.edit', $payment->id) }}">{{ $payment->id }}</a></td>
                                    <td>{{ $payment->user->first_name ?? 'N/A' }}</td>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        {{-- INICIO: LÓGICA DE ESTADOS CON COLORES Y EN ESPAÑOL --}}
                                        @php
                                            $statusClasses = [
                                                'paid' => 'badge-success', 
                                                'approved' => 'badge-success',
                                                'pending' => 'badge-warning', 
                                                'overdue' => 'badge-danger', 
                                                'rejected' => 'badge-dark'
                                            ];
                                            $statusText = [
                                                'paid' => 'Pagado',
                                                'approved' => 'Aprobado',
                                                'pending' => 'Pendiente',
                                                'overdue' => 'Vencido',
                                                'rejected' => 'Rechazado'
                                            ];
                                            $class = $statusClasses[$payment->status] ?? 'badge-secondary';
                                            $text = $statusText[$payment->status] ?? ucfirst($payment->status);
                                        @endphp
                                        <span class="badge {{ $class }}">{{ $text }}</span>
                                        {{-- FIN: LÓGICA DE ESTADOS --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection