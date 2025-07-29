<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Auth::user()->documents()->latest()->get();
        return view('documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $file = $request->file('document_file');
        
        // Guarda el archivo en una carpeta específica para el usuario
        $path = $file->store("documents/{$user->id}", 'public');

        Document::create([
            'user_id' => $user->id,
            'document_type' => $request->document_type,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Documento subido exitosamente.');
    }

    public function destroy(Document $document)
    {
        // Asegurarse de que el usuario solo pueda borrar sus propios documentos
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        // Borra el archivo del storage
        Storage::disk('public')->delete($document->file_path);
        
        // Borra el registro de la base de datos
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Documento eliminado exitosamente.');
    }
}
