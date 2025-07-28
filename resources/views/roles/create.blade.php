@extends('layouts.app')
@section('title', 'Crear Nuevo Rol')
@section('content')
<div class="content-header">
    <!-- ... (breadcrumb) ... -->
</div>
<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header"><h3 class="card-title">Formulario de Nuevo Rol</h3></div>
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nombre del Rol</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar Rol</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection