@extends('layouts.app')
@section('title', 'Editar Zona/Torre')
@section('content')
<!-- Encabezado de Página -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editando Torre: {{ $tower->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('zones.index') }}">Zonas</a></li>
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
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Formulario de Edición de Torre</h3></div>
                <form method="POST" action="{{ route('zones.update', $tower->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nombre / Identificador de la Torre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tower->name) }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <hr>
                        <h5 class="mb-3">Ubicación</h5>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state_id">Estado</label>
                                    <select class="form-control @error('state_id') is-invalid @enderror" id="state_id" name="state_id" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ old('state_id', $tower->municipality->city->state->id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_id">Ciudad</label>
                                    <select class="form-control @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required></select>
                                    @error('city_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="municipality_id">Municipio</label>
                                    <select class="form-control @error('municipality_id') is-invalid @enderror" id="municipality_id" name="municipality_id" required></select>
                                    @error('municipality_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Dirección Específica (Opcional)</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $tower->address) }}</textarea>
                            @error('address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <hr>
                        <h5 class="mb-3">Detalles Técnicos</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="capacity">Capacidad de Clientes</label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity', $tower->capacity) }}" required>
                                    @error('capacity') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Estado de la Torre</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="active" {{ old('status', $tower->status) == 'active' ? 'selected' : '' }}>Activa</option>
                                        <option value="maintenance" {{ old('status', $tower->status) == 'maintenance' ? 'selected' : '' }}>En Mantenimiento</option>
                                        <option value="offline" {{ old('status', $tower->status) == 'offline' ? 'selected' : '' }}>Fuera de Línea</option>
                                    </select>
                                    @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Actualizar Zona</button>
                        <a href="{{ route('zones.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state_id');
    const citySelect = document.getElementById('city_id');
    const municipalitySelect = document.getElementById('municipality_id');
    
    function fetchCities(stateId, selectedCityId = null) {
        if (!stateId) {
            citySelect.innerHTML = '<option value="">Seleccione una Ciudad</option>';
            municipalitySelect.innerHTML = '<option value="">Seleccione un Municipio</option>';
            return;
        }
        fetch('/api/get-cities', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ state_id: stateId })
        })
        .then(response => response.json())
        .then(data => {
            let options = '<option value="">Seleccione una Ciudad</option>';
            data.forEach(city => {
                const selected = selectedCityId == city.id ? 'selected' : '';
                options += `<option value="${city.id}" ${selected}>${city.name}</option>`;
            });
            citySelect.innerHTML = options;
            if (selectedCityId) {
                citySelect.dispatchEvent(new Event('change'));
            }
        });
    }

    function fetchMunicipalities(cityId, selectedMunicipalityId = null) {
        if (!cityId) {
            municipalitySelect.innerHTML = '<option value="">Seleccione un Municipio</option>';
            return;
        }
        fetch('/api/get-municipalities', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ city_id: cityId })
        })
        .then(response => response.json())
        .then(data => {
            let options = '<option value="">Seleccione un Municipio</option>';
            data.forEach(municipality => {
                const selected = selectedMunicipalityId == municipality.id ? 'selected' : '';
                options += `<option value="${municipality.id}" ${selected}>${municipality.name}</option>`;
            });
            municipalitySelect.innerHTML = options;
        });
    }

    stateSelect.addEventListener('change', () => fetchCities(stateSelect.value));
    citySelect.addEventListener('change', () => fetchMunicipalities(citySelect.value));

    // Cargar datos iniciales al cargar la página
    const initialStateId = '{{ old('state_id', $tower->municipality->city->state->id) }}';
    const initialCityId = '{{ old('city_id', $tower->municipality->city->id) }}';
    const initialMunicipalityId = '{{ old('municipality_id', $tower->municipality_id) }}';

    if (initialStateId) {
        fetchCities(initialStateId, initialCityId);
        if (initialCityId) {
            fetchMunicipalities(initialCityId, initialMunicipalityId);
        }
    }
});
</script>
@endpush