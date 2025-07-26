@extends('layouts.app')

@section('title', 'Pagos Pendientes')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pagos Pendientes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Pagos Pendientes</li>
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
                    <h3 class="card-title">Listado de pagos pendientes de aprobación</h3>
                </div>
                <div class="card-body">
                    <table id="pending-payments-table" class="table table-bordered table-hover w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Monto</th>
                                <th>Fecha Pago</th>
                                <th>Mes Pagado</th>
                                <th>Comprobante</th>
                                @if(auth()->user()->role_id == 1)
                                <th>Acciones</th>
                                @endif
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
    // Verificar que jQuery esté disponible
    if (typeof $ === 'undefined') {
        console.error('jQuery no está disponible');
        return;
    }

    $('#pending-payments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('payments.pending') }}",
        columns: [
            { data: 'id', name: 'payments.id' },
            { data: 'user_name', name: 'user.first_name' },
            { data: 'formatted_amount', name: 'amount' },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'month_paid', name: 'month_paid' },
            { data: 'receipt_link', orderable: false, searchable: false },
            @if(auth()->user()->role_id == 1)
            { data: 'actions', orderable: false, searchable: false }
            @endif
        ],
        responsive: true,
        autoWidth: false,
        language: {
            "decimal": "",
            "emptyTable": "No hay pagos pendientes",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "infoPostFix": "",
            "thousands": ",",
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
    }); // <-- Asegúrate de que este paréntesis de cierre esté presente
}); // <-- Cierre del event listener
</script>
@endpush