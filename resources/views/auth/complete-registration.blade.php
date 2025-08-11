<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Registro - Intelcon</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: linear-gradient(135deg, #17a2b8, #007bff); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-5">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">¡Bienvenido! Completa tu Registro</h2>
                            <p class="text-muted">Solo necesitas llenar tus datos una vez para activar tu cuenta.</p>
                        </div>
                        <form method="POST" action="{{ route('register.complete') }}">
                            @csrf
                            <div class="form-group">
                                <label>Cédula de Identidad</label>
                                <input type="text" class="form-control bg-light" name="identification" value="{{ $identification }}" readonly>
                            </div>
                            <!-- ... (Aquí van los mismos campos del formulario de registro: first_name, last_name, email, password, password_confirmation) ... -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-info btn-lg">Completar Registro y Acceder</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
