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
                        
                        {{-- Este botón activará el input de archivo que está en el formulario de abajo --}}
                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('profile_photo').click();">
                            <i class="fas fa-camera"></i> Cambiar Foto
                        </button>
                    </div>

                    <!-- SECCIÓN DE INFORMACIÓN DEL PERFIL -->
                    <h5 class="mb-3 text-primary">Información del Perfil</h5>
                    <form class="form-horizontal" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        {{-- Input de archivo oculto que se activa con el botón de arriba --}}
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
                        
                        <!-- CAMPO DE CÉDULA AÑADIDO -->
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
                        
                        <!-- INICIO: SECCIÓN DE VERIFICACIÓN DE CORREO -->
                        @if (!$user->hasVerifiedEmail())
                            <div class="form-group row">
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

                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">Dirección</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-3 col-sm-9">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </div>
                    </form>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script de la vista previa de la foto
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
        
        // --- INICIO: NUEVOS SCRIPTS PARA SWEETALERT2 ---

        // Alert para la actualización del perfil
        @if (session('success_profile'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success_profile') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        // Alert para la actualización de la contraseña
        @if (session('success_password'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success_password') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        // Alert para el envío del correo de verificación
        @if (session('verification-link-sent'))
            Swal.fire({
                icon: 'success',
                title: '¡Enviado!',
                text: '{{ session('verification-link-sent') }}',
                confirmButtonText: 'Entendido'
            });
        @endif
        // --- FIN: NUEVOS SCRIPTS ---
    });
</script>
@endsection