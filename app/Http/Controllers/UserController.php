<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Municipality;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios (clientes).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Obtenemos todos los usuarios que no son administradores (role_id != 1)
            $users = User::with('role')->where('role_id', '!=', 1)->select('users.*');

            return DataTables::of($users)
                ->addColumn('full_name', function($user) {
                    return $user->first_name . ' ' . $user->last_name;
                })
                ->addColumn('role_name', function($user) {
                    // Usamos el nombre del rol si la relación existe
                    return $user->role ? $user->role->name : 'N/A';
                })
                ->addColumn('status_badge', function($user) {
                    // Creamos un badge basado en el estado del servicio
                    $class = $user->service === 'activo' ? 'badge-success' : 'badge-danger';
                    return '<span class="badge '.$class.'">'.ucfirst($user->service ?? 'Inactivo').'</span>';
                })
                ->addColumn('actions', function($user) {
                    $viewButton = '<a href="'.route('users.show', $user->id).'" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a>';
                    $editButton = '<a href="'.route('users.edit', $user->id).'" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>';
                    $deleteButton = '<button class="btn btn-sm btn-danger delete-btn" data-id="'.$user->id.'" title="Eliminar"><i class="fas fa-trash"></i></button>';
                    return '<div class="btn-group">'.$viewButton.$editButton.$deleteButton.'</div>';
                })
                ->rawColumns(['status_badge', 'actions'])
                ->make(true);
        }

        return view('users.index');
    }

    public function show(User $user)
    {
        // Carga los pagos del usuario, ordenados por el más reciente
        $payments = $user->payments()->latest()->paginate(10);

        return view('users.show', compact('user', 'payments'));
    }

    public function create()
    {
        // Pasamos los roles y estados a la vista para los selectores
        $roles = Role::where('id', '!=', 1)->get(); // Excluir el rol de Admin
        $states = State::all();
        
        return view('users.create', compact('roles', 'states'));
    }

    /**
     * Almacena un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:20', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'role_id' => ['required', 'exists:roles,id'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'municipality_id' => ['required', 'exists:municipalities,id'],
        ]);

        // Asigna la contraseña hasheada
        $validated['password'] = Hash::make($request->password);

        // Maneja la subida de la foto de perfil si existe
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Cliente registrado exitosamente.');
    }

    public function edit(User $user)
    {
        // Obtiene los roles para el selector (excluyendo el rol de Admin si no quieres que se asigne)
        $roles = Role::all(); 
        $states = State::all();
        
        // Carga las ciudades y municipios basados en la selección actual del usuario
        $cities = $user->state_id ? City::where('state_id', $user->state_id)->get() : collect();
        $municipalities = $user->city_id ? Municipality::where('city_id', $user->city_id)->get() : collect();

        // Pasa todas las variables a la vista
        return view('users.edit', compact('user', 'roles', 'states', 'cities', 'municipalities'));
    }

    /**
     * Actualiza un cliente existente en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:20', ValidationRule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', ValidationRule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'role_id' => ['required', 'exists:roles,id'], // Valida que el rol exista
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'municipality_id' => ['required', 'exists:municipalities,id'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            $validated = Arr::except($validated, ['password']);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        try {
            // Elimina la foto de perfil si existe
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->delete();

            return response()->json(['success' => true, 'message' => 'Cliente eliminado exitosamente.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el cliente.'], 500);
        }
    }
}
