@extends('layouts.app')

@section('title', 'Detalle del Cliente')

@section('content')
<!-- Encabezado de Página -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detalle del Cliente</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Detalle</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container-fluid">
    {{-- Se usa justify-content-center para centrar la columna --}}
    <div class="row justify-content-center">
        {{-- Una sola columna más ancha para contener todo --}}
        <div class="col-lg-10 col-xl-8">

            <!-- Tarjeta de Información del Perfil -->
            <div class="card card-primary card-outline mb-4">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/user.png') }}"
                             alt="Foto de perfil del usuario">
                    </div>
                    <h3 class="profile-username text-center">{{ $user->first_name }} {{ $user->last_name }}</h3>
                    <p class="text-muted text-center">{{ $user->role->name ?? 'Cliente' }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Cédula</b> <a class="float-right">{{ $user->identification }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Servicio</b> 
                            <span class="float-right badge {{ $user->service === 'activo' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($user->service ?? 'Inactivo') }}
                            </span>
                        </li>
                    </ul>

                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block"><b>Editar Cliente</b></a>
                </div>
            </div>

            <!-- Tarjeta de Historial de Pagos -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Historial de Pagos</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mes Pagado</th>
                                <th>Monto</th>
                                <th>Fecha de Pago</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->month_paid)->format('F Y') }}</td>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $statusClasses = ['paid' => 'badge-success', 'pending' => 'badge-warning', 'overdue' => 'badge-danger', 'approved' => 'badge-success', 'rejected' => 'badge-danger'];
                                            $class = $statusClasses[$payment->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $class }}">{{ ucfirst($payment->status) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-xs btn-info">
                                            <i class="fas fa-search"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Este cliente no tiene pagos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $payments->links() }}
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection