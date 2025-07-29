@extends('layouts.app')

@section('title', 'Clientes con Servicios')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Clientes con Servicios Asignados</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Asignaciones</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de servicios activos por cliente</h3>
                    <div class="card-tools d-flex align-items-center">
                        <div class="input-group input-group-sm" style="width: 350px;">
                            <input type="text" id="custom-search-input" class="form-control float-right" placeholder="Buscar asignación...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <a href="{{ route('service-assignments.create') }}" class="btn btn-primary ml-3">
                            <i class="fas fa-plus-circle mr-1"></i> Asignar Servicio
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="assignments-table" class="table table-bordered table-hover w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Servicio Asignado</th>
                                <th>Fecha de Inicio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
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
    var table = $('#assignments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('service-assignments.index') }}",
        columns: [
            { data: 'id', name: 'service_user.id' },
            { data: 'full_name', name: 'users.first_name' },
            { data: 'service_name', name: 'services.name' },
            { data: 'start_date', name: 'service_user.start_date' },
            { data: 'status_badge', name: 'service_user.status' },
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
            "emptyTable": "No hay asignaciones de servicios registradas.",
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
