@extends('layouts.app')

@section('title', 'Pagos Morosos')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pagos Morosos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Pagos</a></li>
                    <li class="breadcrumb-item active">Pagos Morosos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">Listado de clientes con pagos vencidos</h3>
                    <div class="card-tools d-flex align-items-center">
                        <div class="input-group input-group-sm" style="width: 350px;">
                            <input type="text" id="custom-search-input" class="form-control float-right" placeholder="Buscar...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        @if(auth()->user()->role_id == 1)
                            <button class="btn btn-dark btn-sm ml-3" id="notify-all">
                                <i class="fas fa-bell"></i> Notificar a todos
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table id="overdue-payments-table" class="table table-bordered table-hover w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Monto</th>
                                <th>Fecha Pago</th>
                                <th>Mes Adeudado</th>
                                <th>Días en Mora</th>
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
    .dataTables_wrapper .row:last-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }
    .dataTables_paginate {
        display: flex;
        justify-content: center;
        flex-grow: 1;
    }
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
    var table = $('#overdue-payments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('payments.overdue') }}",
        columns: [
            { data: 'id', name: 'payments.id' },
            { data: 'user_name', name: 'user.first_name' },
            { data: 'formatted_amount', name: 'amount' },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'month_paid', name: 'month_paid' },
            { data: 'days_overdue', name: 'days_overdue' }, // Asumiendo que el backend lo calcula
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
            "emptyTable": "No hay pagos morosos en este momento.",
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
        },
        createdRow: function(row, data, dataIndex) {
            // Resaltar filas con más de 30 días de mora
            if (parseInt(data.days_overdue) > 30) {
                $(row).addClass('bg-danger');
            }
        }
    });

    // Manejo de notificación individual
    $(document).on('click', '.notify-btn', function() {
        const paymentId = $(this).data('id');
        // Aquí iría tu lógica para notificar
    });

    // Vincula la barra de búsqueda personalizada con la tabla
    $('#custom-search-input').on('keyup', function(){
        table.search(this.value).draw();
    });

    // Manejo de notificación masiva
    $('#notify-all').click(function() {
        // Lógica para notificar a todos los morosos
    });
});
</script>
@endpush

@push('styles')
<style>
    /* Estilos personalizados */
    .bg-danger {
        background-color: #ffcccc !important;
    }
    #overdue-payments-table tbody tr:hover {
        background-color: #fff3cd !important;
    }
    .dataTables_filter input {
        margin-left: 10px !important;
        display: inline-block !important;
        width: auto !important;
    }
    .dt-buttons {
        margin-bottom: 15px;
    }
    .dt-buttons .btn {
        margin-right: 5px;
    }
</style>
@endpush