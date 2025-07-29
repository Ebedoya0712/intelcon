<?php

namespace App\Http\Controllers;

use App\Models\Tower;
use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $towers = Tower::with('municipality.city.state')->select('towers.*');
            return DataTables::of($towers)
                ->addColumn('location', function($tower) {
                    $state = $tower->municipality->city->state->name ?? 'N/A';
                    $city = $tower->municipality->city->name ?? 'N/A';
                    $municipality = $tower->municipality->name ?? 'N/A';
                    return "$state > $city > $municipality";
                })
                ->addColumn('status_badge', function($tower) {
                    $class = $tower->status === 'active' ? 'badge-success' : ($tower->status === 'maintenance' ? 'badge-warning' : 'badge-danger');
                    return '<span class="badge '.$class.'">'.ucfirst($tower->status).'</span>';
                })
                ->addColumn('actions', function($tower) {
                    $editButton = '<a href="'.route('zones.edit', $tower->id).'" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>';
                    $deleteButton = '<button class="btn btn-sm btn-danger delete-btn" data-id="'.$tower->id.'" title="Eliminar"><i class="fas fa-trash"></i></button>';
                    return '<div class="btn-group">'.$editButton.$deleteButton.'</div>';
                })
                ->rawColumns(['status_badge', 'actions'])
                ->make(true);
        }
        return view('zones.index');
    }

    public function create()
    {
        $states = State::all();
        return view('zones.create', compact('states'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'municipality_id' => 'required|exists:municipalities,id',
            'address' => 'nullable|string',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|in:active,maintenance,offline',
        ]);
        Tower::create($validated);
        return redirect()->route('zones.index')->with('success', 'Zona/Torre creada exitosamente.');
    }

    public function edit(Tower $zone) // Laravel's Route Model Binding
    {
        $states = State::all();
        return view('zones.edit', ['tower' => $zone, 'states' => $states]);
    }

    public function update(Request $request, Tower $zone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'municipality_id' => 'required|exists:municipalities,id',
            'address' => 'nullable|string',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|in:active,maintenance,offline',
        ]);
        $zone->update($validated);
        return redirect()->route('zones.index')->with('success', 'Zona/Torre actualizada exitosamente.');
    }

    public function destroy(Tower $zone)
    {
        $zone->delete();
        return response()->json(['success' => true, 'message' => 'Zona/Torre eliminada exitosamente.']);
    }
}
