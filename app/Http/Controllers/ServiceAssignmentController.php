<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ServiceAssignmentController extends Controller
{
    /**
     * Muestra una lista de todas las asignaciones de servicios.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $assignments = DB::table('service_user')
                ->join('users', 'service_user.user_id', '=', 'users.id')
                ->join('services', 'service_user.service_id', '=', 'services.id')
                ->select(
                    'service_user.id',
                    'users.first_name',
                    'users.last_name',
                    'services.name as service_name',
                    'service_user.start_date',
                    'service_user.status'
                );

            return DataTables::of($assignments)
                ->addColumn('full_name', fn($row) => $row->first_name . ' ' . $row->last_name)
                ->addColumn('status_badge', function($row) {
                    // --- INICIO DE LA MODIFICACIÓN ---
                    // Traducciones para los estados
                    $statusTranslations = [
                        'active' => 'Activo',
                        'inactive' => 'Inactivo',
                        'suspended' => 'Suspendido',
                    ];
                    $text = $statusTranslations[$row->status] ?? ucfirst($row->status);
                    
                    // Asignar clase de color según el estado
                    $class = '';
                    switch ($row->status) {
                        case 'active':
                            $class = 'badge-success';
                            break;
                        case 'suspended':
                            $class = 'badge-danger'; // Color rojo para suspendido
                            break;
                        default:
                            $class = 'badge-secondary';
                            break;
                    }
                    
                    return '<span class="badge '.$class.'">'.$text.'</span>';
                    // --- FIN DE LA MODIFICACIÓN ---
                })
                ->addColumn('actions', function($row) {
                    return '<a href="'.route('service-assignments.edit', $row->id).'" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['status_badge', 'actions'])
                ->make(true);
        }
        return view('service_assignments.index');
    }

    /**
     * Muestra el formulario para crear una nueva asignación de servicio.
     */
    public function create()
    {
        $clients = User::where('role_id', '!=', 1)->orderBy('first_name')->get();
        $activeServices = Service::where('status', 'active')->orderBy('name')->get();

        return view('service_assignments.create', compact('clients', 'activeServices'));
    }

    /**
     * Almacena una nueva asignación de servicio en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'start_date' => 'required|date',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $user = User::find($validated['user_id']);
        $user->services()->attach($validated['service_id'], [
            'start_date' => $validated['start_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('service-assignments.index')->with('success', 'Servicio asignado exitosamente.');
    }

    /**
     * Muestra el formulario para editar una asignación.
     */
    public function edit($id)
    {
        $assignment = DB::table('service_user')->where('id', $id)->first();
        $clients = User::where('role_id', '!=', 1)->orderBy('first_name')->get();
        $activeServices = Service::where('status', 'active')->orderBy('name')->get();

        return view('service_assignments.edit', compact('assignment', 'clients', 'activeServices'));
    }

    /**
     * Actualiza una asignación en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'start_date' => 'required|date',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        DB::table('service_user')->where('id', $id)->update([
            'user_id' => $validated['user_id'],
            'service_id' => $validated['service_id'],
            'start_date' => $validated['start_date'],
            'status' => $validated['status'],
            'updated_at' => now(),
        ]);

        return redirect()->route('service-assignments.index')->with('success', 'Asignación actualizada exitosamente.');
    }
}
