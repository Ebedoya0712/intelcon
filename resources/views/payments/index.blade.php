@extends('layouts.app')

@section('title', 'Listado de Pagos')

@section('content')
<!-- Encabezado de Página -->
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

<!-- Contenido Principal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Todos los pagos registrados</h3>
                    <div class="card-tools">
                        <a href="{{ route('payments.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle mr-1"></i> Nuevo Pago
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="payments-table" class="table table-bordered table-striped">
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
                        <tbody>
                            <!-- Los datos se cargarán via AJAX -->
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<style>
    .btn-action {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    .badge-status {
        font-size: 0.9rem;
        padding: 0.35em 0.65em;
    }
</style>
@endpush

@push('scripts')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {
    const table = $('#payments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('payments.datatable') }}",
        columns: [
            { data: 'id', name: 'id' },
            { 
                data: 'user', 
                name: 'user.first_name',
                render: function(data, type, row) {
                    return data ? data.first_name + ' ' + data.last_name : 'N/A';
                }
            },
            { 
                data: 'amount', 
                name: 'amount',
                render: function(data) {
                    return '$' + parseFloat(data).toFixed(2);
                }
            },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'month_paid', name: 'month_paid' },
            { 
                data: 'status', 
                name: 'status',
                render: function(data) {
                    let badgeClass = '';
                    switch(data) {
                        case 'paid':
                            badgeClass = 'badge-success';
                            data = 'Pagado';
                            break;
                        case 'pending':
                            badgeClass = 'badge-warning';
                            data = 'Pendiente';
                            break;
                        case 'overdue':
                            badgeClass = 'badge-danger';
                            data = 'Vencido';
                            break;
                        default:
                            badgeClass = 'badge-secondary';
                    }
                    return `<span class="badge ${badgeClass} badge-status">${data}</span>`;
                }
            },
            { 
                data: 'receipt_path', 
                name: 'receipt_path',
                render: function(data) {
                    if (!data) return 'N/A';
                    return `<a href="/storage/${data}" target="_blank" class="btn btn-sm btn-info btn-action">
                                <i class="fas fa-eye"></i> Ver
                            </a>`;
                },
                orderable: false
            },
            { 
                data: 'id', 
                name: 'actions',
                render: function(data, type, row) {
                    return `
                    <div class="btn-group">
                        <a href="/payments/${data}/edit" class="btn btn-sm btn-primary btn-action" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger btn-action delete-btn" title="Eliminar" data-id="${data}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>`;
                },
                orderable: false,
                searchable: false
            }
        ],
        responsive: true,
        autoWidth: false,
        language: {
            url: "{{ asset('plugins/datatables/Spanish.json') }}"
        }
    });

    // Manejar eliminación
    $(document).on('click', '.delete-btn', function() {
        const paymentId = $(this).data('id');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
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
                        table.ajax.reload();
                        Swal.fire(
                            '¡Eliminado!',
                            'El pago ha sido eliminado.',
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
});
</script>
@endpush