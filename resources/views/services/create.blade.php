@extends('layouts.app')

@section('title', 'Registrar Nuevo Servicio')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registrar Nuevo Servicio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Servicios</a></li>
                    <li class="breadcrumb-item active">Registrar</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Nuevo Servicio</h3>
                </div>
                {{-- Se añade un ID al formulario --}}
                <form method="POST" action="{{ route('services.store') }}" id="createServiceForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nombre del Plan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="speed_mbps">Velocidad (Mbps)</label>
                            <input type="number" class="form-control @error('speed_mbps') is-invalid @enderror" id="speed_mbps" name="speed_mbps" value="{{ old('speed_mbps') }}" required>
                            @error('speed_mbps') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Precio Mensual ($)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                            @error('price') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción (Opcional)</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Estado</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active" selected>Activo</option>
                                <option value="discontinued">Descontinuado</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Servicio</button>
                        <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createServiceForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Previene el envío inmediato del formulario

            Swal.fire({
                title: '¿Confirmar Registro?',
                text: "Estás a punto de crear un nuevo servicio.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, registrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, envía el formulario
                    form.submit();
                }
            });
        });
    }
});
</script>
@endpush