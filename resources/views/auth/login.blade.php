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
            padding: 1rem;
        }
        .card {
            border: none;
            border-radius: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.5s ease forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card:focus-within {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 0 0 0.25rem rgba(0, 123, 255, 0.3);
        }
        .form-control:focus {
            box-shadow: none;
        }
        .forgot-password-link {
            font-size: 0.9rem;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 col-xl-5">
                <div class="card p-5">
                    <div class="card-body">
                        <!-- Contenedor del encabezado -->
                        <div class="d-flex flex-column align-items-center mb-4">
                            <h2 class="card-title fw-bold mb-3">Acceso al Sistema</h2>
                            <img src="{{ asset('images/intelconn.jpg') }}" alt="Logo de Intelcon" class="mb-3" style="width: 150px;">
                            <p class="text-muted small">Intelcon Gestión</p>
                        </div>

                        <form method="POST" action="{{ route('auth.attempt') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="identification" class="form-label fw-bold">Cédula de Identidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
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
                                    <label for="password" class="form-label fw-bold">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                        <input type="password" id="password" name="password" 
                                               class="form-control" placeholder="••••••••">
                                    </div>
                                </div>
                            </div>

                            <!-- INICIO: SECCIÓN DE RECUÉRDAME Y OLVIDÉ CONTRASEÑA -->
                            <div class="d-flex justify-content-between align-items-center my-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Recuérdame
                                    </label>
                                </div>
                                <div>
                                    {{-- ENLACE CORREGIDO --}}
                                    <a href="{{ route('password.request') }}" class="forgot-password-link">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                            <!-- FIN: NUEVA SECCIÓN -->

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    Ingresar
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                             <small class="text-muted">&copy; {{ date('Y') }} Intelcon. Todos los derechos reservados.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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