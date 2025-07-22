<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intelcon - Iniciar Sesión</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Estilo para un fondo con gradiente más atractivo */
        body {
            background: linear-gradient(135deg, #007bff, #33A5FF);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 1rem;
            transition: all 0.3s;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg p-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/intelconn.jpg') }}" alt="Logo de Intelcon" class="mx-auto mb-3" style="width: 180px;">
                            <h2 class="card-title mt-3 mb-1">Acceso al Sistema</h2>
                            <p class="text-muted">Intelcon-Gestión</p>
                        </div>

                        <form method="POST" action="{{ route('auth.attempt') }}">
                            @csrf {{-- Token de seguridad indispensable --}}

                            <div class="mb-3">
                                <label for="identification" class="form-label fw-bold">Ingrese su Cédula de Identidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                    {{-- El name="identification" debe coincidir con el del controlador --}}
                                    <input type="text" id="identification" name="identification" value="{{ old('identification') }}" 
                                           class="form-control @error('identification') is-invalid @enderror" 
                                           placeholder="V-12345678" required autofocus>
                                    
                                    @error('identification')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="collapse" id="passwordCollapse">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-bold">Ingrese su Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                        <input type="password" id="password" name="password" 
                                               class="form-control" placeholder="••••••••">
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    Ingresar
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                             <small class="text-muted">&copy; 2025 Intelcon. Todos los derechos reservados.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Los scripts ahora son manejados por Vite, pero el código específico de la página va aquí --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Script para el colapso de la contraseña
            const identificationInput = document.getElementById('identification');
            const passwordCollapseEl = document.getElementById('passwordCollapse');
            const passwordInput = document.getElementById('password');
            
            const bsCollapse = new bootstrap.Collapse(passwordCollapseEl, {
                toggle: false
            });

            identificationInput.addEventListener('input', function() {
                if (this.value.length > 0) {
                    bsCollapse.show();
                    passwordInput.required = true;
                } else {
                    bsCollapse.hide();
                    passwordInput.required = false;
                }
            });

            // Script para SweetAlert2
            @if (session('error_user_not_found'))
                Swal.fire({
                    icon: 'error',
                    title: 'Acceso Denegado',
                    text: '{{ session('error_user_not_found') }}',
                    confirmButtonText: 'Registrarme',
                    confirmButtonColor: '#198754',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("solicitud.acceso") }}';
                    }
                });
            @endif
        });
    </script>
</body>
</html>