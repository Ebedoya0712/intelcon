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
                    <li class="breadcrumb-item active">Pagos Morosos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Listado de pagos con mora</h3>
                    @if(auth()->user()->role_id == 1)
                    <div class="card-tools">
                        <button class="btn btn-sm btn-dark" id="notify-all">
                            <i class="fas fa-bell"></i> Notificar a todos
                        </button>
                    </div>
                    @endif
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = [
        {
            extend: 'copy',
            text: '<i class="fas fa-copy"></i> Copiar',
            className: 'btn btn-secondary btn-sm',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5] // Excluye la columna de acciones
            }
        },
        {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            className: 'btn btn-danger btn-sm',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5]
            },
            customize: function(doc) {
                doc.content[1].table.body[0].forEach(function(cell, index) {
                    cell.fillColor = '#ff0000';
                    cell.color = '#ffffff';
                });
            }
        },
        {
            extend: 'print',
            text: '<i class="fas fa-print"></i> Imprimir',
            className: 'btn btn-info btn-sm',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5]
            }
        }
    ];

    $('#overdue-payments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('payments.overdue') }}",
        dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: {
            dom: {
                button: {
                    className: 'btn'
                }
            },
            buttons: buttons
        },
        columns: [
            { data: 'id', name: 'payments.id' },
            { data: 'user_name', name: 'user.first_name' },
            { data: 'formatted_amount', name: 'amount' },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'month_paid', name: 'month_paid' },
            { data: 'days_overdue', name: 'days_overdue', orderable: true },
            { data: 'actions', orderable: false, searchable: false }
        ],
        responsive: true,
        autoWidth: false,
        language: {
            "decimal": "",
            "emptyTable": "No hay pagos morosos",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "searchPlaceholder": "Buscar pagos...",
            "zeroRecords": "No se encontraron registros coincidentes",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        initComplete: function() {
            // Mover la barra de búsqueda a la derecha
            $('.dataTables_filter').addClass('float-right');
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