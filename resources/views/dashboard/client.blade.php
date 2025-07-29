@extends('layouts.app')

@section('title', 'Mi Dashboard')

@section('content')
<!-- Encabezado de Página -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Bienvenido, {{ Auth::user()->first_name }}</h1>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container-fluid">
    <!-- Cajas de Estadísticas del Cliente -->
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($totalPaid, 2) }}</h3>
                    <p>Total Pagado Histórico</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendingClientPayments }}</h3>
                    <p>Pagos Pendientes de Aprobación</p>
                </div>
                <div class="icon"><i class="fas fa-hourglass-half"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $overdueClientPayments }}</h3>
                    <p>Pagos Vencidos</p>
                </div>
                <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>

    <!-- Información del Servicio Activo -->
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-wifi mr-2"></i>Mi Servicio Activo</h3>
                </div>
                <div class="card-body">
                    @if($activeService)
                        <h4><strong>Plan:</strong> {{ $activeService->name }}</h4>
                        <p class="lead">Disfrutas de una velocidad de <strong>{{ $activeService->speed_mbps }} Mbps</strong>.</p>
                        <ul class="list-unstyled">
                            <li><strong>Precio Mensual:</strong> ${{ number_format($activeService->price, 2) }}</li>
                            <li><strong>Fecha de Activación:</strong> {{ \Carbon\Carbon::parse($activeService->start_date)->format('d/m/Y') }}</li>
                        </ul>
                        <a href="{{-- route('my-payments.create') --}}" class="btn btn-primary mt-2">
                            <i class="fas fa-money-bill-wave mr-1"></i> Reportar un Pago
                        </a>
                    @else
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Sin Servicio Activo</h5>
                            Actualmente no tienes un servicio de internet asignado. Por favor, contacta a soporte.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
