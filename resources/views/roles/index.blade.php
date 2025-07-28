@extends('layouts.app')
@section('title', 'Gestión de Usuarios y Roles')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">Gestión de Usuarios y Roles</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Usuarios y Roles</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Usuarios y sus Roles</h3>
            <div class="card-tools d-flex align-items-center">
                <div class="input-group input-group-sm" style="width: 350px;">
                    <input type="text" id="custom-search-input" class="form-control float-right" placeholder="Buscar usuario...">
                </div>
                <a href="{{ route('roles.create') }}" class="btn btn-primary ml-3"><i class="fas fa-plus-circle mr-1"></i> Nuevo Rol</a>
            </div>
        </div>
        <div class="card-body">
            <table id="users-roles-table" class="table table-bordered table-hover w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol Actual</th>
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
    var table = $('#users-roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('roles.index') }}",
            data: function (d) {
                d.except_current = true;
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { 
                data: null, 
                name: 'first_name', // Permite buscar por nombre
                render: function(data, type, row) {
                    return row.first_name + ' ' + row.last_name;
                }
            },
            { data: 'email', name: 'email' },
            { 
                data: 'role.name', 
                name: 'role.name',
                render: function(data, type, row) {
                    return data || 'Sin rol asignado';
                }
            },
            { 
                data: 'actions', 
                name: 'actions',
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    if(row.id != {{ auth()->id() }}) {
                        var url = "{{ route('users.edit', ':id') }}".replace(':id', row.id);
                        return `<a href="${url}" class="btn btn-sm btn-primary" title="Editar rol">
                                    <i class="fas fa-user-edit"></i>
                                </a>`;
                    }
                    return '';
                }
            }
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
            "emptyTable": "No hay usuarios registrados.",
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
