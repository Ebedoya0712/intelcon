<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    /**
     * Muestra una lista de todos los pagos (vista de admin).
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $payments = Payment::with('user')->select('payments.*');
        
        return DataTables::of($payments)
            ->addColumn('user_name', function($payment) {
                return $payment->user->first_name . ' ' . $payment->user->last_name;
            })
            ->addColumn('formatted_amount', function($payment) {
                return '$' . number_format($payment->amount, 2);
            })
            ->addColumn('status_badge', function($payment) {
                $status = $payment->status;
                $class = $status === 'approved' ? 'badge-success' : 
                        ($status === 'pending' ? 'badge-warning' : 'badge-danger');
                return '<span class="badge '.$class.'">'.ucfirst($status).'</span>';
            })
            ->addColumn('receipt_link', function($payment) {
                return $payment->receipt_path 
                    ? '<a href="'.asset('storage/'.$payment->receipt_path).'" target="_blank">Ver comprobante</a>'
                    : 'Sin comprobante';
            })
            ->addColumn('actions', function($payment) {
                return '
                    <div class="btn-group">
                        <a href="'.route('payments.edit', $payment->id).'" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="'.$payment->id.'">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['status_badge', 'receipt_link', 'actions'])
            ->make(true);
    }

    return view('payments.index');
}

    /**
     * Muestra el formulario correcto para registrar un pago, dependiendo del rol del usuario.
     */
    public function create()
    {
        if (Auth::user()->role_id == 1) {
            $users = User::orderBy('first_name')->get();
            return view('payments.create', compact('users'));
        }

        return view('payments.client.create');
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

            $path = $request->file('receipt_path')->store('receipts', 'public');
            
            Payment::create([
                'user_id' => Auth::user()->role_id == 1 ? $validatedData['user_id'] : Auth::id(),
                'status' => Auth::user()->role_id == 1 ? $validatedData['status'] : 'pending',
                'receipt_path' => $path,
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

    /**
     * Muestra el formulario para editar un pago.
     */
    public function edit(Payment $payment)
    {
        $users = User::orderBy('first_name')->get();
        return view('payments.edit', compact('payment', 'users'));
    }

    /**
     * Actualiza un pago en la base de datos.
     */
    public function update(Request $request, Payment $payment)
    {
        try {
            $validatedData = $request->validate([
                'amount' => 'required|numeric|min:0',
                'payment_date' => 'required|date',
                'month_paid' => 'required|date_format:Y-m',
                'status' => 'required|in:paid,pending,overdue',
                'receipt_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'notes' => 'nullable|string',
            ]);

            if ($request->hasFile('receipt_path')) {
                // Eliminar el archivo antiguo si existe
                if ($payment->receipt_path) {
                    Storage::disk('public')->delete($payment->receipt_path);
                }
                $path = $request->file('receipt_path')->store('receipts', 'public');
                $validatedData['receipt_path'] = $path;
            }

            $payment->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => '¡Pago actualizado exitosamente!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el pago: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un pago de la base de datos.
     */
    public function destroy(Payment $payment)
    {
        try {
            // Eliminar el archivo si existe
            if ($payment->receipt_path) {
                Storage::disk('public')->delete($payment->receipt_path);
            }

            $payment->delete();

            return response()->json([
                'success' => true,
                'message' => '¡Pago eliminado exitosamente!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el pago: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra los pagos pendientes.
     */
    public function pending()
    {
        $payments = Payment::where('status', 'pending')->with('user')->latest()->paginate(15);
        return view('payments.pending', compact('payments'));
    }
}