@extends('layouts.app')

@section('title', 'Listado de Pagos')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Listado de Pagos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Pagos</li>
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
                    <h3 class="card-title">Todos los pagos registrados</h3>
                    <div class="card-tools">
                        <a href="{{ route('payments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle mr-1"></i> Nuevo Pago
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="payments-table" class="table table-bordered table-hover w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Monto</th>
                                <th>Fecha Pago</th>
                                <th>Mes Pagado</th>
                                <th>Estado</th>
                                <th>Comprobante</th>
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
    /* Estilos personalizados para DataTables */
    .dataTables_filter input {
        width: 300px !important;
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ddd;
        margin-left: 10px;
    }

    .dataTables_filter label {
        display: flex;
        align-items: center;
        font-weight: normal;
    }

    .dt-buttons .btn {
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .dataTables_length label {
        display: flex;
        align-items: center;
    }

    .dataTables_length select {
        margin: 0 5px;
        width: auto !important;
    }
</style>
@endpush

@push('scripts')
<script>
// Función para inicializar DataTable con todas las dependencias
async function initializePaymentDataTable() {
    // Verificar dependencias
    if (typeof $ === 'undefined') {
        console.error('jQuery no está disponible');
        return;
    }

    // Configurar botones
    const buttons = [
        {
            extend: 'copy',
            text: '<i class="fas fa-copy"></i> Copiar',
            className: 'btn btn-secondary btn-sm',
            exportOptions: { columns: ':visible' }
        },
        {
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Excel',
            className: 'btn btn-success btn-sm',
            exportOptions: { columns: ':visible' }
        },
        {
            extend: 'print',
            text: '<i class="fas fa-print"></i> Imprimir',
            className: 'btn btn-info btn-sm',
            exportOptions: { columns: ':visible' }
        }
    ];

    // Añadir PDF solo si está disponible
    if (typeof pdfMake !== 'undefined') {
        buttons.push({
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            className: 'btn btn-danger btn-sm',
            exportOptions: { columns: ':visible' },
            customize: function (doc) {
                doc.defaultStyle.fontSize = 8;
                doc.styles.tableHeader.fontSize = 10;
            }
        });
    } else {
        console.warn('Exportación a PDF no disponible - pdfMake no está definido');
    }

    // Inicializar DataTable
    $('#payments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('payments.index') }}",
        dom: `
            <"row"
                <"col-md-6 col-sm-12"l>
                <"col-md-6 col-sm-12"f>
            >
            <"row dt-table"
                <"col-sm-12"tr>
            >
            <"row"
                <"col-md-5 col-sm-12"i>
                <"col-md-7 col-sm-12"p>
            >
            <"row"
                <"col-sm-12 col-md-6"B>
            >
        `,
        buttons: buttons,
        columns: [
            { data: 'id', name: 'payments.id', orderable: true },
            { data: 'user_name', name: 'user.first_name', orderable: true },
            { data: 'formatted_amount', name: 'amount', orderable: true },
            { data: 'payment_date', name: 'payment_date', orderable: true },
            { data: 'month_paid', name: 'month_paid', orderable: true },
            { data: 'status_badge', name: 'status', orderable: true },
            { data: 'receipt_link', orderable: false, searchable: false },
            { 
                data: 'actions', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group">
                            <a href="/payments/${row.id}/edit" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
        "decimal": "",
        "emptyTable": "No hay datos disponibles en la tabla",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "No se encontraron registros coincidentes",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "aria": {
            "sortAscending": ": activar para ordenar ascendente",
            "sortDescending": ": activar para ordenar descendente"
        },
        "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad de columnas",
            "collection": "Colección",
            "colvisRestore": "Restaurar visibilidad",
            "copyKeys": "Presione Ctrl o ⌘ + C para copiar los datos de la tabla al portapapeles.<br><br>Para cancelar, haga clic en este mensaje o presione escape.",
            "copySuccess": {
                "_": "%d filas copiadas",
                "1": "1 fila copiada"
            },
            "copyTitle": "Copiar al portapapeles",
            "csv": "CSV",
            "excel": "Excel",
            "pageLength": {
                "_": "Mostrar %d filas",
                "-1": "Mostrar todas las filas"
            },
            "print": "Imprimir",
            "renameState": "Cambiar nombre",
            "updateState": "Actualizar",
            "createState": "Crear Estado",
            "removeAllStates": "Remover Estados",
            "removeState": "Remover",
            "savedStates": "Estados Guardados",
            "stateRestore": "Estado %d"
        }
    },
        responsive: true,
        autoWidth: false
    });

    // Manejo de eliminación
    $(document).on('click', '.delete-btn', function() {
        const paymentId = $(this).data('id');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/payments/${paymentId}`,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#payments-table').DataTable().ajax.reload();
                        Swal.fire(
                            '¡Eliminado!',
                            'El pago ha sido eliminado correctamente.',
                            'success'
                        );
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error',
                            'Ocurrió un error al eliminar el pago.',
                            'error'
                        );
                    }
                });
            }
        });
    });
}

// Esperar a que todas las dependencias estén cargadas
window.addEventListener('allDependenciesLoaded', function() {
    initializePaymentDataTable();
});

// Plan B: Si el evento no se dispara, intentar después de 1 segundo
setTimeout(() => {
    if (typeof $ !== 'undefined' && typeof $.fn.DataTable !== 'undefined') {
        initializePaymentDataTable();
    } else {
        console.warn('Las dependencias no se cargaron correctamente, reintentando...');
        setTimeout(initializePaymentDataTable, 1000);
    }
}, 1000);
</script>
@endpush