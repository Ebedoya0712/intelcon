<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Intelcon</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: linear-gradient(135deg, #007bff, #33A5FF); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-5">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Recuperar Contraseña</h2>
                            <p class="text-muted">Ingresa tu correo y te enviaremos un enlace para recuperarla.</p>
                        </div>

                        {{-- El formulario ahora apunta al endpoint correcto --}}
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                {{-- El error de validación normal se mantiene por si acaso --}}
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar Enlace</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script para los alerts de SweetAlert2 --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Alert de ÉXITO
            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Enviado!',
                    text: '{{ session('status') }}',
                    confirmButtonText: 'Entendido'
                });
            @endif

            // Alert de ERROR (Correo no encontrado)
            @if (session('error_email_not_found'))
                Swal.fire({
                    icon: 'error',
                    title: 'Correo no encontrado',
                    text: '{{ session('error_email_not_found') }}',
                    confirmButtonText: 'Solicitar Acceso',
                    confirmButtonColor: '#198754', // Color verde
                    showCancelButton: true,
                    cancelButtonText: 'Intentar de nuevo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirige a la vista de solicitud si el usuario lo desea
                        window.location.href = '{{ route("solicitud.acceso") }}';
                    }
                });
            @endif
        });
    </script>
</body>
</html>
