<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminDocumentController extends Controller
{
    /**
     * Muestra una lista de todos los documentos subidos por los clientes.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $documents = Document::with('user')->select('documents.*');

                return DataTables::of($documents)
                    ->addColumn('user_name', function($document) {
                        // Usamos optional() para evitar errores si un usuario fue eliminado
                        return optional($document->user)->first_name . ' ' . optional($document->user)->last_name;
                    })
                    ->addColumn('formatted_date', function($document) {
                        // Formatea la fecha para que sea más legible
                        return Carbon::parse($document->created_at)->format('d/m/Y h:i A');
                    })
                    ->addColumn('actions', function($document) {
                        $viewButton = '<a href="'.asset('storage/' . $document->file_path).'" target="_blank" class="btn btn-sm btn-info" title="Ver Documento"><i class="fas fa-eye"></i></a>';
                        return '<div class="btn-group">'.$viewButton.'</div>';
                    })
                    ->rawColumns(['actions'])
                    ->make(true);

            } catch (\Exception $e) {
                // Si ocurre cualquier error, lo registraremos y enviaremos una respuesta de error JSON
                Log::error($e->getMessage());
                return response()->json(['error' => 'Ocurrió un error al cargar los datos.'], 500);
            }
        }

        return view('admin.documents.index');
    }
}
