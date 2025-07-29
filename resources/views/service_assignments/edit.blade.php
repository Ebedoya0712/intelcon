@extends('layouts.app')

@section('title', 'Editar Asignación de Servicio')

@section('content')
<!-- Encabezado de Página -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Asignación de Servicio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('service-assignments.index') }}">Asignaciones</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Editando Asignación #{{ $assignment->id }}</h3>
                </div>
                <form method="POST" action="{{ route('service-assignments.update', $assignment->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user_id">Cliente</label>
                            <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">-- Elija un cliente --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('user_id', $assignment->user_id) == $client->id ? 'selected' : '' }}>
                                        {{ $client->first_name }} {{ $client->last_name }} (C.I: {{ $client->identification }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="service_id">Servicio Activo</label>
                            <select class="form-control @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                                <option value="">-- Elija un servicio --</option>
                                @foreach($activeServices as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id', $assignment->service_id) == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} ({{ $service->speed_mbps }} Mbps)
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_date">Fecha de Inicio del Servicio</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $assignment->start_date) }}" required>
                            @error('start_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Estado de la Asignación</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $assignment->status) == 'active' ? 'selected' : '' }}>Activo</option>
                                <option value="inactive" {{ old('status', $assignment->status) == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                <option value="suspended" {{ old('status', $assignment->status) == 'suspended' ? 'selected' : '' }}>Suspendido</option>
                            </select>
                            @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Actualizar Asignación</button>
                        <a href="{{ route('service-assignments.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
