@extends('layouts.app')
@section('title', 'Mis Documentos')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">Mis Documentos</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Mis Documentos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Columna para Subir Documentos -->
        <div class="col-md-5">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Subir Nuevo Documento</h3></div>
                <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="document_type">Tipo de Documento</label>
                            <select class="form-control @error('document_type') is-invalid @enderror" id="document_type" name="document_type" required>
                                <option value="">Seleccione...</option>
                                <option value="Cédula de Identidad" {{ old('document_type') == 'Cédula de Identidad' ? 'selected' : '' }}>Cédula de Identidad</option>
                                <option value="RIF" {{ old('document_type') == 'RIF' ? 'selected' : '' }}>RIF</option>
                                <option value="Contrato Firmado" {{ old('document_type') == 'Contrato Firmado' ? 'selected' : '' }}>Contrato Firmado</option>
                                <option value="Otro" {{ old('document_type') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('document_type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="document_file">Archivo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('document_file') is-invalid @enderror" id="document_file" name="document_file" required>
                                <label class="custom-file-label" for="document_file">Elegir archivo...</label>
                            </div>
                            @error('document_file') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            <small class="form-text text-muted">Formatos: PDF, JPG, PNG. Tamaño máx: 2MB.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload mr-2"></i>Subir Documento</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna para Listar Documentos -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Documentos Cargados</h3></div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr><th>Tipo de Documento</th><th>Nombre del Archivo</th><th>Fecha de Subida</th><th>Acciones</th></tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                            <tr>
                                <td>{{ $doc->document_type }}</td>
                                <td>{{ $doc->original_name }}</td>
                                <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-xs btn-info" title="Ver"><i class="fas fa-eye"></i></a>
                                    
                                    <!-- INICIO: FORMULARIO DE ELIMINACIÓN MODIFICADO -->
                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                    <!-- FIN: FORMULARIO DE ELIMINACIÓN MODIFICADO -->
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center">Aún no has subido ningún documento.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Script para mostrar el nombre del archivo en el input
    const fileInput = document.getElementById('document_file');
    if(fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Elegir archivo...';
            const nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    }

    // Script para el alert de SweetAlert2 de éxito
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    // INICIO: NUEVO SCRIPT PARA CONFIRMACIÓN DE BORRADO
    $('.delete-form').on('submit', function(e) {
        e.preventDefault(); // Previene el envío inmediato
        var form = this;

        Swal.fire({
            title: '¿Estás seguro de eliminar este documento?', // TEXTO CORREGIDO
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, ¡eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Si el usuario confirma, envía el formulario
            }
        });
    });
    // FIN: NUEVO SCRIPT
});
</script>
@endpush
