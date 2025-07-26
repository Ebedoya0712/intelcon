    @extends('layouts.app')

    @section('title', 'Registrar Pago')

    @section('content')
    <!-- Encabezado de Página -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Registrar Mi Pago</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Registrar Pago</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Información del Pago, Por favor sube el comprobante de tu pago</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data" id="paymentForm">
                        @csrf
                        <div class="card-body">
                            <!-- Campos ocultos para Cliente -->
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="status" value="pending">

                            <div class="form-group">
                                <label for="amount">Monto Pagado ($)</label>
                                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                    id="amount" name="amount" value="{{ old('amount') }}" 
                                    placeholder="Ej: 50.00" required>
                                @error('amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_date">Fecha del Pago</label>
                                        <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                                            id="payment_date" name="payment_date" 
                                            value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                        @error('payment_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month_paid">Mes que estás pagando</label>
                                        <input type="month" class="form-control @error('month_paid') is-invalid @enderror" 
                                            id="month_paid" name="month_paid" 
                                            value="{{ old('month_paid', date('Y-m')) }}" required>
                                        @error('month_paid') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="receipt_path">Comprobante de Pago</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('receipt_path') is-invalid @enderror" 
                                            id="receipt_path" name="receipt_path" required accept="image/*,.pdf">
                                        <label class="custom-file-label" for="receipt_path" id="fileLabel">Seleccionar archivo...</label>
                                    </div>
                                </div>
                                @error('receipt_path') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                <small class="form-text text-muted">
                                    Formatos aceptados: JPG, PNG, PDF. Tamaño máximo: 2MB
                                </small>
                                
                                <!-- Preview de la imagen -->
                                <div class="mt-3" id="imagePreviewContainer" style="display:none;">
                                    <h6>Vista previa:</h6>
                                    <div class="border p-2 text-center bg-light">
                                        <img id="imagePreview" src="#" alt="Preview del comprobante" class="img-fluid" style="max-height: 200px; display: none;">
                                        <div id="pdfPreview" style="display: none;">
                                            <i class="fas fa-file-pdf fa-5x text-danger"></i>
                                            <p class="mt-2 mb-0" id="pdfFileName"></p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removeImage">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Información adicional (Opcional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" 
                                        placeholder="Ej: Número de transacción, referencia bancaria, etc.">{{ old('notes') }}</textarea>
                            </div>

                            <div class="alert alert-info mt-3">
                                <i class="icon fas fa-info-circle"></i>
                                Tu pago será verificado por nuestro equipo en un plazo máximo de 24 horas.
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check-circle mr-2"></i> Registrar Pago
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... (código existente para preview de imagen)

        const paymentForm = document.getElementById('paymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Obtener el token CSRF correctamente
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Problema de seguridad. Por favor recarga la página.',
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }

                // Resto del código de validación...
                const receiptFile = document.getElementById('receipt_path').files[0];
                if (!receiptFile) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Debes subir un comprobante de pago válido',
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }

                // Mostrar confirmación
                const { isConfirmed } = await Swal.fire({
                    title: '¿Registrar pago?',
                    text: '¿Estás seguro de que deseas registrar este pago?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, registrar',
                    cancelButtonText: 'Cancelar'
                });

                if (isConfirmed) {
                    try {
                        const formData = new FormData(paymentForm);
                        
                        // Mostrar loader
                        Swal.fire({
                            title: 'Procesando...',
                            html: 'Estamos registrando tu pago',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });

                        // Enviar mediante fetch
                        const response = await fetch(paymentForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) throw new Error(data.message || 'Error en la respuesta');

                        // Mostrar éxito y recargar
                        await Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message,
                            confirmButtonText: 'Aceptar'
                        });
                        
                        window.location.reload();

                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Ocurrió un error al procesar el pago',
                            confirmButtonText: 'Entendido'
                        });
                    }
                }
            });
        }
    });
    </script>
    @endpush