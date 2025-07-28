@extends('layouts.app')

@section('title', 'Editar Servicio')

@section('content')
<div class="content-header">
    <!-- ... (breadcrumb) ... -->
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Editando Servicio: {{ $service->name }}</h3>
                </div>
                <form method="POST" action="{{ route('services.update', $service->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nombre del Plan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $service->name) }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="speed_mbps">Velocidad (Mbps)</label>
                            <input type="number" class="form-control @error('speed_mbps') is-invalid @enderror" id="speed_mbps" name="speed_mbps" value="{{ old('speed_mbps', $service->speed_mbps) }}" required>
                            @error('speed_mbps') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Precio Mensual ($)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $service->price) }}" required>
                            @error('price') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción (Opcional)</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $service->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Estado</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active" {{ $service->status == 'active' ? 'selected' : '' }}>Activo</option>
                                <option value="discontinued" {{ $service->status == 'discontinued' ? 'selected' : '' }}>Descontinuado</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Actualizar Servicio</button>
                        <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
