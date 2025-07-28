@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<!-- Encabezado de Página -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Cliente: {{ $user->first_name }} {{ $user->last_name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Edición de Cliente</h3>
                </div>
                <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Se usa PUT para actualizar --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">Nombre</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                    @error('first_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Apellido</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="identification">Cédula</label>
                                    <input type="text" class="form-control @error('identification') is-invalid @enderror" id="identification" name="identification" value="{{ old('identification', $user->identification) }}" required>
                                    @error('identification') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Nueva Contraseña (Opcional)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3">Información Adicional</h5>

                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                            @error('address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state_id">Estado</label>
                                    <select class="form-control @error('state_id') is-invalid @enderror" id="state_id" name="state_id" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ old('state_id', $user->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_id">Ciudad</label>
                                    <select class="form-control @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="municipality_id">Municipio</label>
                                    <select class="form-control @error('municipality_id') is-invalid @enderror" id="municipality_id" name="municipality_id" required>
                                        @foreach($municipalities as $municipality)
                                            <option value="{{ $municipality->id }}" {{ old('municipality_id', $user->municipality_id) == $municipality->id ? 'selected' : '' }}>{{ $municipality->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('municipality_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_id">Rol de Usuario</label>
                                    <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile_photo">Foto de Perfil (Opcional)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo">
                                        <label class="custom-file-label" for="profile_photo">Elegir archivo</label>
                                    </div>
                                    @error('profile_photo') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Actualizar Datos Del Cliente</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Aquí va el mismo script de los selectores dinámicos que usamos en el perfil
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
            let options = citySelect.innerHTML;
            data.forEach(city => {
                const selected = selectedCityId == city.id ? 'selected' : '';
                if (!options.includes(`value="${city.id}"`)) {
                    options += `<option value="${city.id}" ${selected}>${city.name}</option>`;
                }
            });
            citySelect.innerHTML = options;
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
            let options = municipalitySelect.innerHTML;
            data.forEach(municipality => {
                const selected = selectedMunicipalityId == municipality.id ? 'selected' : '';
                if (!options.includes(`value="${municipality.id}"`)) {
                    options += `<option value="${municipality.id}" ${selected}>${municipality.name}</option>`;
                }
            });
            municipalitySelect.innerHTML = options;
        });
    }

    stateSelect.addEventListener('change', function() {
        citySelect.innerHTML = '<option value="">Cargando ciudades...</option>';
        fetchCities(this.value);
    });
    citySelect.addEventListener('change', function() {
        municipalitySelect.innerHTML = '<option value="">Cargando municipios...</option>';
        fetchMunicipalities(this.value);
    });
});
</script>
@endpush
