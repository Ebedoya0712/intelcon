<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    /**
     * Muestra una lista de todos los servicios.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $services = Service::query();
            return DataTables::of($services)
                ->addColumn('formatted_price', fn($service) => '$' . number_format($service->price, 2))
                ->addColumn('status_badge', function($service) {
                    $class = $service->status === 'active' ? 'badge-success' : 'badge-secondary';
                    return '<span class="badge '.$class.'">'.ucfirst($service->status).'</span>';
                })
                ->addColumn('actions', function($service) {
                    $editButton = '<a href="'.route('services.edit', $service->id).'" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>';
                    $deleteButton = '<button class="btn btn-sm btn-danger delete-btn" data-id="'.$service->id.'" title="Eliminar"><i class="fas fa-trash"></i></button>';
                    return '<div class="btn-group">'.$editButton.$deleteButton.'</div>';
                })
                ->rawColumns(['status_badge', 'actions'])
                ->make(true);
        }
        return view('services.index');
    }

    public function showAssignForm()
    {
        // Obtenemos solo los usuarios que son clientes (role_id != 1)
        $clients = User::where('role_id', '!=', 1)->orderBy('first_name')->get();

        // Obtenemos solo los servicios que están activos
        $activeServices = Service::where('status', 'active')->orderBy('name')->get();

        return view('services.assign', compact('clients', 'activeServices'));
    }

    /**
     * Almacena la asignación del servicio en la base de datos.
     */
    public function assign(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $user = User::findOrFail($validated['user_id']);
        
        // Actualiza el service_id del usuario
        $user->update([
            'service_id' => $validated['service_id']
        ]);

        return redirect()->route('services.assign.form')->with('success', '¡Servicio asignado a ' . $user->first_name . ' exitosamente!');
    }

    /**
     * Muestra el formulario para crear un nuevo servicio.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Almacena un nuevo servicio en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'speed_mbps' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,discontinued',
        ]);

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Servicio creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un servicio existente.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Actualiza un servicio existente en la base de datos.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'speed_mbps' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,discontinued',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Servicio actualizado exitosamente.');
    }

    /**
     * Elimina un servicio de la base de datos.
     */
    public function destroy(Service $service)
    {
        try {
            // Validación activada: no se puede eliminar un servicio si está en uso.
            if ($service->users()->exists()) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar un servicio que está asignado a clientes.'], 409); // 409 Conflict
            }

            $service->delete();
            return response()->json(['success' => true, 'message' => 'Servicio eliminado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el servicio.'], 500);
        }
    }
}
