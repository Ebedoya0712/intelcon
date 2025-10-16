<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intelcon - Iniciar Sesión</title>

    {{-- Asegúrate de que SweetAlert2 y Bootstrap estén incluidos en app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    {{-- Para SweetAlert2, si no está en app.js: <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

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
            max-width: 450px; /* Limita el ancho en pantallas grandes */
            width: 100%;
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
        /* Estilos para el campo de contraseña que se muestra/oculta con animación */
        #passwordSection {
            overflow: hidden;
            transition: max-height 0.5s ease-out, opacity 0.5s ease-out;
            max-height: 0;
            opacity: 0;
        }
        #passwordSection.show-password {
            max-height: 150px; /* Suficientemente grande para el contenido */
            opacity: 1;
        }
        .solicitar-acceso-link {
            font-size: 0.9rem;
            text-decoration: none;
            color: #007bff;
            transition: color 0.2s ease;
        }
        .solicitar-acceso-link:hover {
            color: #0056b3;
            text-decoration: underline;
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

                        <form method="POST" action="{{ route('auth.attempt') }}" id="loginForm">
                            @csrf

                            <div class="mb-3">
                                <label for="identification" class="form-label fw-bold">Cédula de Identidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                    <input type="text" id="identification" name="identification" 
                                           value="{{ old('identification') }}" 
                                           class="form-control @error('identification') is-invalid @enderror" 
                                           placeholder="V-12345678" required autofocus>
                                </div>
                                
                                {{-- Muestra el error de identificación/contraseña --}}
                                @error('identification')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- SECCIÓN DE CONTRASEÑA (Inicialmente oculta y controlada por JS) --}}
                            <div class="mb-3" id="passwordSection">
                                <label for="password" class="form-label fw-bold">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" id="password" name="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="••••••••">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                    <a href="{{ route('password.request') }}" class="forgot-password-link">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                            <!-- FIN: SECCIÓN -->

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold" id="submitButton">
                                    Ingresar
                                </button>
                            </div>

                            <!-- NUEVA SECCIÓN: SOLICITAR ACCESO -->
                            <div class="text-center mt-4">
                                <p class="text-muted small mb-2">
                                    ¿Estás interesado en nuestros servicios?
                                </p>
                                <a href="/solicitud-acceso" class="solicitar-acceso-link fw-bold">
                                    Solicita un acceso
                                </a>
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
            const passwordSection = document.getElementById('passwordSection');
            const passwordInput = document.getElementById('password');
            const loginForm = document.getElementById('loginForm'); // Referencia al formulario
            const submitButton = document.getElementById('submitButton'); // Referencia al botón
            const baseUrl = '{{ url('/') }}';
            
            // Estado para evitar múltiples submits accidentales
            let isChecking = false;

            // Función principal para verificar y decidir
            async function checkUserPasswordStatus() {
                if (isChecking) return;
                isChecking = true;
                submitButton.disabled = true; // Deshabilitar el botón durante la verificación
                
                const identification = identificationInput.value.trim();
                
                // Ocultar por defecto
                passwordSection.classList.remove('show-password');
                passwordInput.required = false;

                if (identification.length > 5) { 
                    try {
                        const response = await fetch(`${baseUrl}/api/check-password-status/${identification}`);
                        const data = await response.json();
                        
                        // *** LOG PARA DEBUGGING ***
                        console.log('API Response:', data);
                        console.log('Requires password:', data.requires_password);
                        
                        // Si el usuario REQUIERE CONTRASEÑA (ya la tiene en la DB)
                        if (data.requires_password) {
                            // 1. Mostrar campo de contraseña
                            passwordSection.classList.add('show-password');
                            passwordInput.required = true;
                            submitButton.disabled = false; // Habilitar para que pueda hacer submit
                        } else {
                            // 2. Si NO requiere contraseña (pre-registro o no existe)
                            // FORZAMOS EL SUBMIT del formulario al backend. El backend redirigirá.
                            loginForm.submit();
                            // IMPORTANT: Salimos inmediatamente de la función tras el submit programático
                            return; 
                        }
                    } catch (error) {
                        console.error('Error al verificar el estado de la contraseña:', error);
                        // En caso de error de red, mostramos el campo para permitir el login normal
                        passwordSection.classList.add('show-password');
                        passwordInput.required = true;
                        submitButton.disabled = false;
                    }
                } else {
                    // Si el campo de identificación está vacío o muy corto
                    submitButton.disabled = false;
                }
                
                isChecking = false;
            }
            
            // Función que maneja el submit, interceptando si la contraseña no es necesaria
            loginForm.addEventListener('submit', function(e) {
                // Si la sección de contraseña está oculta, evitamos el submit por ahora
                // y llamamos a la función de verificación/redirección.
                if (!passwordSection.classList.contains('show-password')) {
                    e.preventDefault();
                    checkUserPasswordStatus();
                }
                // Si la sección SÍ está visible, dejamos que el formulario haga submit normal
            });
            
            // 1. Ejecutar la verificación al cargar si el campo ya tiene valor (ej. error de validación)
            if (identificationInput.value.trim().length > 0) {
                 checkUserPasswordStatus();
            }
            
            // 2. Lógica para mostrar/ocultar el campo al salir del foco (blur) (NO USADO PARA SUBMIT)
            identificationInput.addEventListener('blur', function() {
                // Si el campo de contraseña ya está visible, no hacemos nada.
                if (!passwordSection.classList.contains('show-password')) {
                    checkUserPasswordStatus();
                }
            });

            // Lógica de SweetAlert2 para el error de usuario no encontrado (si aplica)
            @if (session('error_user_not_found'))
                Swal.fire({
                    icon: 'error',
                    title: 'Acceso Denegado',
                    text: '{{ session('error_user_not_found') }}',
                    confirmButtonText: 'Solicitar Acceso',
                    confirmButtonColor: '#198754',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("solicitud.acceso") }}';
                    }
                });
            @endif

            // Asegurar que el campo se muestre si hubo error de contraseña en la carga inicial
            @error('password')
                passwordSection.classList.add('show-password');
                passwordInput.required = true;
                submitButton.disabled = false;
            @enderror

        });
    </script>
</body>
</html>