@extends('layouts.app')
@section('title', 'Pre-Registrar Cliente')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">Pre-Registrar Cliente</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Pre-Registro</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-info">
                <div class="card-header"><h3 class="card-title">Registrar Cédula de Nuevo Cliente</h3></div>
                <form method="POST" action="{{ route('users.pre-register.store') }}">
                    @csrf
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <p class="text-muted">Introduce la cédula del cliente. El cliente podrá completar el resto de sus datos la primera vez que intente iniciar sesión.</p>
                        <div class="form-group">
                            <label for="identification">Cédula de Identidad</label>
                            <input type="text" class="form-control @error('identification') is-invalid @enderror" id="identification" name="identification" value="{{ old('identification') }}" required>
                            @error('identification') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Pre-Registrar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
