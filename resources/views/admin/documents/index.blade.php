@extends('layouts.app')
@section('title', 'Documentos de Clientes')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">Documentos de Clientes</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Documentos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de todos los documentos subidos por los clientes</h3>
            <div class="card-tools d-flex align-items-center">
                <div class="input-group input-group-sm" style="width: 350px;">
                    <input type="text" id="custom-search-input" class="form-control float-right" placeholder="Buscar documento o cliente...">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="documents-table" class="table table-bordered table-hover w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Tipo de Documento</th>
                        <th>Nombre del Archivo</th>
                        <th>Fecha de Subida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Contenedor inferior (Botones y Paginación) */
    .dataTables_wrapper .row:last-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }
    /* Paginación centrada */
    .dataTables_paginate {
        display: flex;
        justify-content: center;
        flex-grow: 1;
    }
    /* Botones a la izquierda */
    .dt-buttons {
        text-align: left;
    }
    .dt-buttons .btn {
        margin-right: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var table = $('#documents-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.documents.index') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user_name', name: 'user.first_name' },
            { data: 'document_type', name: 'document_type' },
            { data: 'original_name', name: 'original_name' },
            { data: 'formatted_date', name: 'created_at' },
            { data: 'actions', orderable: false, searchable: false }
        ],
        responsive: true,
        autoWidth: false,
        dom:  "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-12 col-md-5'B><'col-sm-12 col-md-7'p>>",
        buttons: [
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copiar', className: 'btn btn-secondary' },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success' },
            { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-danger' },
            { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir', className: 'btn btn-info' }
        ],
        language: {
            "emptyTable": "No hay documentos registrados.",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros coincidentes",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

    // Vincula la barra de búsqueda personalizada con la tabla
    $('#custom-search-input').on('keyup', function(){
        table.search(this.value).draw();
    });
});
</script>
@endpush
