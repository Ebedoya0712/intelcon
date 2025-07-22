<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intelcon - Iniciar Sesión</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

                        <form method="POST" action="{{ route('login') }}">
                            @csrf {{-- Token de seguridad indispensable --}}

                            <div class="mb-3">
                                <label for="cedula" class="form-label fw-bold">Ingrese su Cédula de Identidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                    <input type="text" id="cedula" name="cedula" value="{{ old('cedula') }}" 
                                           class="form-control @error('cedula') is-invalid @enderror" 
                                           placeholder="V-12345678" required autofocus>
                                    
                                    @error('cedula')
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cedulaInput = document.getElementById('cedula');
            const passwordCollapseEl = document.getElementById('passwordCollapse');
            const passwordInput = document.getElementById('password');
            
            // Inicializa el componente Collapse de Bootstrap sin mostrarlo
            const bsCollapse = new bootstrap.Collapse(passwordCollapseEl, {
                toggle: false
            });

            cedulaInput.addEventListener('input', function() {
                // Si el campo de cédula tiene texto, muestra el campo de contraseña
                if (this.value.length > 0) {
                    bsCollapse.show();
                    passwordInput.required = true;
                } else {
                    // Si está vacío, lo oculta
                    bsCollapse.hide();
                    passwordInput.required = false;
                }
            });
        });
    </script>
</body>
</html>