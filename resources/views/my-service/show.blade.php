@extends('layouts.app')

@section('title', 'Mi Servicio')

@section('content')
<!-- Encabezado de Página -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Resumen de Mi Servicio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Mi Servicio</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container-fluid">
    @if($activeService)
        <div class="row">
            <!-- Columna de Estado de Cuenta -->
            <div class="col-md-4">
                <div class="card card-{{ $paymentData['statusClass'] }} card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Estado de tu Cuenta</h3>
                    </div>
                    <div class="card-body text-center">
                        @if($paymentData['daysRemaining'] >= 0)
                            <h1 class="display-3 font-weight-bold">{{ $paymentData['daysRemaining'] }}</h1>
                            <p class="lead">Días restantes para tu próximo pago</p>
                        @else
                            <h1 class="display-3 font-weight-bold">{{ abs($paymentData['daysRemaining']) }}</h1>
                            <p class="lead">Días de retraso en tu pago</p>
                        @endif
                        
                        <hr>
                        <p><strong>Próxima Fecha de Pago:</strong> {{ $paymentData['nextDueDate']->format('d/m/Y') }}</p>
                        <h4><span class="badge bg-{{ $paymentData['statusClass'] }}">{{ $paymentData['paymentStatus'] }}</span></h4>
                    </div>
                </div>
            </div>

            <!-- Columna de Detalles del Plan -->
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-wifi mr-2"></i>Detalles de tu Plan Contratado</h3>
                    </div>
                    <div class="card-body">
                        <h3 class="text-primary">{{ $activeService->name }}</h3>
                        <p class="lead">Disfrutas de una velocidad de <strong>{{ $activeService->speed_mbps }} Mbps</strong>.</p>
                        <ul class="list-unstyled">
                            <li><strong><i class="fas fa-dollar-sign text-success"></i> Precio Mensual:</strong> ${{ number_format($activeService->price, 2) }}</li>
                            <li><strong><i class="fas fa-calendar-check text-info"></i> Fecha de Activación:</strong> {{ \Carbon\Carbon::parse($activeService->start_date)->format('d/m/Y') }}</li>
                        </ul>
                        <a href="{{ route('payments.create') }}" class="btn btn-lg btn-success mt-3">
                            <i class="fas fa-money-bill-wave mr-2"></i> Reportar un Pago
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <h5><i class="icon fas fa-info"></i> Sin Servicio Activo</h5>
            Actualmente no tienes un servicio de internet asignado. Por favor, contacta a soporte para más información.
        </div>
    @endif
</div>
@endsection
