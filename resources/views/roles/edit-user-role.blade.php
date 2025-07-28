@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Editar Rol de Usuario</h3>
                </div>
                <form action="{{ route('roles.update-user-role', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" class="form-control" value="{{ $user->first_name }} {{ $user->last_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="role_id">Rol</label>
                            <select class="form-control" id="role_id" name="role_id" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Actualizar Rol</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-default float-right">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection