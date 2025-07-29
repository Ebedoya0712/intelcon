@extends('layouts.app')

@section('title', 'Revisar Pago')

@section('content')
<!-- Encabezado de Página -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Revisar Pago #{{ $payment->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.pending') }}">Pagos Pendientes</a></li>
                    <li class="breadcrumb-item active">Revisar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Revisión del Pago de: {{ $payment->user->first_name }} {{ $payment->user->last_name }}</h3>
                </div>
                <form method="POST" action="{{ route('payments.update', $payment->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Columna de Información -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cliente</label>
                                    <input type="text" class="form-control" value="{{ $payment->user->first_name }} {{ $payment->user->last_name }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Monto del Pago</label>
                                    <input type="number" step="0.01" class="form-control bg-light" id="amount" name="amount" value="{{ $payment->amount }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="payment_date">Fecha de Pago</label>
                                    <input type="date" class="form-control bg-light" id="payment_date" name="payment_date" value="{{ $payment->payment_date }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="month_paid">Mes Correspondiente</label>
                                    <input type="month" class="form-control bg-light" id="month_paid" name="month_paid" value="{{ $payment->month_paid }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="status">Cambiar Estado del Pago</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="paid" {{ old('status', $payment->status) == 'paid' ? 'selected' : '' }}>Aprobado (Paid)</option>
                                        <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pendiente (Pending)</option>
                                        <option value="overdue" {{ old('status', $payment->status) == 'overdue' ? 'selected' : '' }}>Vencido (Overdue)</option>
                                        <option value="rejected" {{ old('status', $payment->status) == 'rejected' ? 'selected' : '' }}>Rechazado (Rejected)</option>
                                    </select>
                                    @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <!-- Columna del Comprobante -->
                            <div class="col-md-6">
                                <label>Comprobante de Pago</label>
                                @if($payment->receipt_path)
                                    <a href="{{ asset('storage/' . $payment->receipt_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $payment->receipt_path) }}" alt="Comprobante" class="img-fluid border rounded">
                                    </a>
                                @else
                                    <div class="alert alert-info">Este pago no tiene un comprobante adjunto.</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="notes">Notas del Administrador</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Añadir notas o comentarios sobre la revisión...">{{ old('notes', $payment->notes) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Actualizar Pago</button>
                        <a href="{{ route('payments.pending') }}" class="btn btn-secondary">Volver a Pendientes</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

