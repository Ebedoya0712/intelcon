@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')

<!-- ENCABEZADO DE PÁGINA -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Perfil de Usuario</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Perfil</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    
                    <!-- SECCIÓN DE FOTO DE PERFIL -->
                    <div class="text-center border-bottom pb-4 mb-4">
                        <img id="profile-picture-preview" class="profile-user-img img-fluid img-circle mb-3"
                             src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/user.png') }}"
                             alt="Foto de perfil del usuario"
                             style="width: 150px; height: 150px; object-fit: cover;">
                        
                        <h3 class="profile-username">{{ $user->first_name }} {{ $user->last_name }}</h3>
                        <p class="text-muted">{{ $user->role->name ?? 'Cliente' }}</p>
                        
                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('profile_photo').click();">
                            <i class="fas fa-camera"></i> Cambiar Foto
                        </button>
                    </div>

                    <!-- SECCIÓN DE INFORMACIÓN DEL PERFIL -->
                    <h5 class="mb-3 text-primary">Información del Perfil</h5>
                    <form class="form-horizontal" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <input type="file" id="profile_photo" name="profile_photo" class="d-none">

                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">Nombre</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-sm-3 col-form-label">Apellido</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="identification" class="col-sm-3 col-form-label">Cédula</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="identification" name="identification" value="{{ $user->identification }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">Dirección</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                            </div>
                        </div>

                        <!-- INICIO: CAMPOS DE UBICACIÓN -->
                        <div class="form-group row">
                            <label for="state_id" class="col-sm-3 col-form-label">Estado</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('state_id') is-invalid @enderror" id="state_id" name="state_id" required>
                                    <option value="">Seleccione un Estado</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ old('state_id', $user->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city_id" class="col-sm-3 col-form-label">Ciudad</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('city_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="municipality_id" class="col-sm-3 col-form-label">Municipio</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('municipality_id') is-invalid @enderror" id="municipality_id" name="municipality_id" required>
                                     @foreach($municipalities as $municipality)
                                        <option value="{{ $municipality->id }}" {{ old('municipality_id', $user->municipality_id) == $municipality->id ? 'selected' : '' }}>{{ $municipality->name }}</option>
                                    @endforeach
                                </select>
                                @error('municipality_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <!-- FIN: CAMPOS DE UBICACIÓN -->

                        <div class="form-group row">
                            <div class="offset-sm-3 col-sm-9">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </div>
                    </form>

                    <!-- INICIO: SECCIÓN DE VERIFICACIÓN DE CORREO (AHORA FUERA DEL FORMULARIO ANTERIOR) -->
                    @if (!$user->hasVerifiedEmail())
                        <div class="form-group row mt-3">
                            <div class="offset-sm-3 col-sm-9">
                                <div class="d-flex justify-content-between align-items-center p-2 bg-light border rounded">
                                    <span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Correo no verificado</span>
                                    <form id="verification-form" method="POST" action="{{ route('verification.send') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Verificar Correo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- FIN: SECCIÓN DE VERIFICACIÓN DE CORREO -->

                    <hr>

                    <!-- SECCIÓN DE CAMBIAR CONTRASEÑA -->
                    <h5 class="mb-3 text-danger">Actualizar Contraseña</h5>
                    <form class="form-horizontal" method="post" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('put')
                        
                        <div class="form-group row">
                            <label for="current_password" class="col-sm-3 col-form-label">Contraseña Actual</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Nueva Contraseña</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-3 col-form-label">Confirmar Contraseña</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-3 col-sm-9">
                                <button type="submit" class="btn btn-danger">Actualizar Contraseña</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- SCRIPT PARA LA FOTO DE PERFIL ---
    const photoInput = document.getElementById('profile_photo');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profile-picture-preview').setAttribute('src', event.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    // --- SCRIPT PARA SELECTS DINÁMICOS ---
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
            let options = citySelect.innerHTML; // Conserva las opciones actuales si existen
            data.forEach(city => {
                const selected = selectedCityId == city.id ? 'selected' : '';
                // Evita duplicados
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
            let options = municipalitySelect.innerHTML; // Conserva las opciones actuales si existen
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
        municipalitySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
        fetchCities(this.value);
    });

    citySelect.addEventListener('change', function() {
        municipalitySelect.innerHTML = '<option value="">Cargando municipios...</option>';
        fetchMunicipalities(this.value);
    });

    // --- SCRIPTS PARA SWEETALERT2 ---
    @if (session('success_profile'))
        Swal.fire({ icon: 'success', title: '¡Éxito!', text: '{{ session('success_profile') }}', timer: 2000, showConfirmButton: false });
    @endif
    @if (session('success_password'))
        Swal.fire({ icon: 'success', title: '¡Éxito!', text: '{{ session('success_password') }}', timer: 2000, showConfirmButton: false });
    @endif
    @if (session('verification-link-sent'))
        Swal.fire({ icon: 'success', title: '¡Enviado!', text: '{{ session('verification-link-sent') }}', confirmButtonText: 'Entendido' });
    @endif
});
</script>
@endpush

@endsection