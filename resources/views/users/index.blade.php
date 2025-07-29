@extends('layouts.app')

@section('title', 'Listado de Clientes')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Listado de Clientes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Clientes</li>
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
                    <h3 class="card-title">Todos los clientes registrados</h3>
                    <div class="card-tools d-flex align-items-center">
                        <div class="input-group input-group-sm" style="width: 350px;">
                            <input type="text" id="custom-search-input" class="form-control float-right" placeholder="Buscar cliente...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <a href="{{ route('users.create') }}" class="btn btn-primary ml-3">
                            <i class="fas fa-plus-circle mr-1"></i> Registrar Cliente
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="users-table" class="table table-bordered table-hover w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Cédula</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado Servicio</th>
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
    .dataTables_wrapper .row:last-child { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
    .dataTables_paginate { display: flex; justify-content: center; flex-grow: 1; }
    .dt-buttons { text-align: left; }
    .dt-buttons .btn { margin-right: 5px; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'full_name', name: 'first_name' }, // Buscable por first_name
            { data: 'identification', name: 'identification' },
            { data: 'email', name: 'email' },
            { data: 'role_name', name: 'role.name' },
            { data: 'status_badge', name: 'service_id' }, // Actualizado para buscar por service_id
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
        language: { "emptyTable": "No hay clientes registrados.", "info": "Mostrando _START_ a _END_ de _TOTAL_ registros", "infoEmpty": "Mostrando 0 a 0 de 0 registros", "infoFiltered": "(filtrado de _MAX_ registros totales)", "lengthMenu": "Mostrar _MENU_ registros", "loadingRecords": "Cargando...", "processing": "Procesando...", "search": "Buscar:", "zeroRecords": "No se encontraron registros coincidentes", "paginate": { "first": "Primero", "last": "Último", "next": "Siguiente", "previous": "Anterior" } }
    });

    $('#custom-search-input').on('keyup', function(){
        table.search(this.value).draw();
    });

    // --- INICIO: LÓGICA PARA EL BOTÓN DE ELIMINAR ---
    $('#users-table').on('click', '.delete-btn', function() {
        const userId = $(this).data('id');

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
                fetch(`/users/${userId}`, {
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
                        table.ajax.reload(); // Recarga la tabla
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
    // --- FIN: LÓGICA PARA EL BOTÓN DE ELIMINAR ---
});
</script>
@endpush
