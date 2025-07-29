<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::with('role')
                ->select(['id', 'first_name', 'last_name', 'email', 'role_id']);

            // Excluir al usuario actualmente autenticado
            if ($request->has('except_current') && $request->except_current) {
                $query->where('id', '!=', auth()->id());
            }

            return DataTables::of($query)
                ->addColumn('actions', function($user) {
                    // Mostrar botón de editar para todos los usuarios excepto el actual
                    if ($user->id != auth()->id()) {
                        return '<a href="'.route('roles.edit-user-role', $user->id).'" class="btn btn-sm btn-primary" title="Editar rol">
                                    <i class="fas fa-user-edit"></i>
                                </a>';
                    }
                    return '';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('roles.index');
    }

    public function editUserRole(User $user)
    {
        // No permitir editar al usuario actual
        if ($user->id == auth()->id()) {
            abort(403, 'No puedes editar tu propio rol');
        }

        $roles = Role::all(); // Mostrar todos los roles incluyendo admin
    
        return view('roles.edit-user-role', compact('user', 'roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|unique:roles|max:255']);
        Role::create($validated);
        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit(Role $role)
    {
        $users = User::where('role_id', $role->id)
                     ->where('id', '!=', Auth::id())
                     ->orderBy('first_name')
                     ->get();
                     
        return view('roles.edit', compact('role', 'users'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$role->id,
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id'
        ]);

        $role->update(['name' => $validated['name']]);
        
        $selectedUserIds = $request->input('users', []);
        
        // Excluir al usuario logueado de los cambios
        $selectedUserIds = array_diff($selectedUserIds, [Auth::id()]);
        
        User::whereIn('id', $selectedUserIds)
            ->update(['role_id' => $role->id]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function updateUserRole(Request $request, User $user)
    {
        // Validar que no sea el usuario actual
        if ($user->id == auth()->id()) {
            abort(403, 'No puedes cambiar tu propio rol');
        }

        $request->validate([
            'role_id' => 'required|exists:roles,id' // Permitir cualquier rol (1, 2, etc.)
        ]);

        $user->update(['role_id' => $request->role_id]);

        return redirect()->route('roles.index')
                        ->with('success', 'Rol de usuario actualizado correctamente');
    }

    public function destroy(Role $role)
    {
        if ($role->id <= 2) {
            return response()->json(['success' => false, 'message' => 'No se pueden eliminar los roles principales.'], 403);
        }
        if ($role->users()->exists()) {
            return response()->json(['success' => false, 'message' => 'No se puede eliminar un rol que está asignado a usuarios.'], 409);
        }
        $role->delete();
        return response()->json(['success' => true, 'message' => 'Rol eliminado exitosamente.']);
    }
}