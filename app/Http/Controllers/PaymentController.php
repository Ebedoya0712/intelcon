<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Muestra una lista de todos los pagos (vista de admin).
     */
    public function index()
    {
        $payments = Payment::with('user')->latest()->paginate(15);
        return view('payments.index', compact('payments'));
    }

    /**
     * Muestra el formulario correcto para registrar un pago, dependiendo del rol del usuario.
     */
    public function create()
    {
        // Si el usuario es Administrador (role_id = 1)
        if (Auth::user()->role_id == 1) {
            $users = User::orderBy('first_name')->get();
            return view('payments.create', compact('users')); // Muestra la vista de admin
        }

        // Si es cualquier otro rol (Cliente)
        return view('payments.client.create'); // Muestra la vista de cliente
    }

    /**
     * Almacena un nuevo pago en la base de datos.
     */
    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'month_paid' => 'required|date_format:Y-m',
            'receipt_path' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Guardar el archivo correctamente
        $file = $request->file('receipt_path');
        $path = $file->store('receipts', 'public'); // Esto guardará en storage/app/public/receipts

        Payment::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'receipt_path' => $path, // Esto guardará la ruta correcta como "receipts/nombrearchivo.ext"
            'amount' => $validatedData['amount'],
            'payment_date' => $validatedData['payment_date'],
            'month_paid' => $validatedData['month_paid'],
            'notes' => $validatedData['notes'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Pago registrado exitosamente! Será verificado pronto.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al registrar el pago: ' . $e->getMessage()
        ], 500);
    }
}

    // ... (otros métodos del resource controller)
}