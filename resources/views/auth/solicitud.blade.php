<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Acceso - Intelcon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Estilo para un fondo con gradiente (el mismo que el login) */
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
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-lg p-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/intelconn.jpg') }}" alt="Logo de Intelcon" class="mx-auto mb-3" style="width: 180px;">
                            <h2 class="card-title mt-2 mb-1">Solicitud de Acceso</h2>
                            <p class="text-muted">
                            <span class="text-danger fw-bold">Parece que tu cédula no está registrada.</span>
                            Por favor, completa tus datos para enviar una solicitud de activación a nuestros asesores.
                            </p>
                        </div>

                        {{-- El action se conectará a la ruta 'solicitud.send' cuando implementes la lógica --}}
                                                <form method="POST" action="{{ route('solicitud.send') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="identification" class="form-label fw-bold">Cédula de Identidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                    {{-- Corregido: name="identification" y un error de comillas extra --}}
                                    <input type="text" id="identification" name="identification" value="{{ old('identification') }}" class="form-control bg-light">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="first_name" class="form-label fw-bold">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    {{-- Corregido: name="first_name" --}}
                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Escribe tu nombre" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label fw-bold">Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    {{-- Corregido: name="last_name" --}}
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Escribe tu apellido" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="telefono" class="form-label fw-bold">Teléfono (WhatsApp)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                    <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Ej: 0412-1234567" required>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success btn-lg fw-bold">
                                    <i class="bi bi-whatsapp"></i> Enviar Solicitud
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

</body>
</html>