@extends('layouts.app')

@section('title', 'Gestión de Servicios')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de Servicios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Servicios</li>
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
                    <h3 class="card-title">Planes de internet disponibles</h3>
                    <div class="card-tools d-flex align-items-center">
                        <div class="input-group input-group-sm" style="width: 350px;">
                            <input type="text" id="custom-search-input" class="form-control float-right" placeholder="Buscar servicio...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <a href="{{ route('services.create') }}" class="btn btn-primary ml-3">
                            <i class="fas fa-plus-circle mr-1"></i> Nuevo Servicio
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="services-table" class="table table-bordered table-hover w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Plan</th>
                                <th>Velocidad (Mbps)</th>
                                <th>Precio Mensual</th>
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
    var table = $('#services-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('services.index') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'speed_mbps', name: 'speed_mbps' },
            { data: 'formatted_price', name: 'price' },
            { data: 'status_badge', name: 'status' },
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
            "emptyTable": "No hay servicios registrados.",
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

    // Lógica para el botón de eliminar
    $('#services-table').on('click', '.delete-btn', function() {
        const serviceId = $(this).data('id');

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, ¡eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/services/${serviceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Eliminado!', data.message, 'success');
                        table.ajax.reload();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'Ocurrió un problema de conexión.', 'error');
                });
            }
        });
    });
});
</script>
@endpush
