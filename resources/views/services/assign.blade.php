@extends('layouts.app')

@section('title', 'Asignar Servicio a Cliente')

@section('content')
<!-- Encabezado de Página -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Asignar Servicio a Cliente</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Servicios</a></li>
                    <li class="breadcrumb-item active">Asignar</li>
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
                    <h3 class="card-title">Seleccione el Cliente y el Servicio a Asignar</h3>
                </div>
                <form method="POST" action="{{ route('services.assign.store') }}">
                    @csrf
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="user_id">Seleccionar Cliente</label>
                            <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">-- Elija un cliente --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('user_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->first_name }} {{ $client->last_name }} (C.I: {{ $client->identification }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="service_id">Seleccionar Servicio Activo</label>
                            <select class="form-control @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                                <option value="">-- Elija un servicio --</option>
                                @foreach($activeServices as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} ({{ $service->speed_mbps }} Mbps - ${{ number_format($service->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Asignar Servicio</button>
                        <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
