<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\OverduePaymentNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException; 

class PaymentController extends Controller
{
    /**
     * Muestra una lista de todos los pagos (vista de admin).
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        // Base query
        $payments = Payment::with('user')->select('payments.*');
        
        // Si no es admin (rol_id != 1), filtrar solo los pagos del usuario autenticado
        if (auth()->user()->role_id != 1) {
            $payments->where('user_id', auth()->id());
        }
        
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
                $editButton = '';
                $deleteButton = '';
                
                // Solo mostrar botones de editar/eliminar si es admin o el pago es del usuario
                if (auth()->user()->role_id == 1 || $payment->user_id == auth()->id()) {
                    $editButton = '<a href="'.route('payments.edit', $payment->id).'" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>';
                    
                    $deleteButton = '<button class="btn btn-sm btn-danger delete-btn" data-id="'.$payment->id.'">
                                    <i class="fas fa-trash"></i>
                                    </button>';
                }
                
                return '<div class="btn-group">'.$editButton.$deleteButton.'</div>';
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
            // 1. Define las reglas de validación base
            $rules = [
                'amount' => 'required|numeric|min:0',
                'payment_date' => 'required|date',
                'month_paid' => 'required|date_format:Y-m',
                'receipt_path' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'notes' => 'nullable|string',
            ];

            // 2. Si es admin, añade reglas adicionales
            if (Auth::user()->role_id == 1) {
                $rules['user_id'] = 'required|exists:users,id';
                $rules['status'] = 'required|in:paid,pending,overdue';
            }

            // 3. Ejecuta la validación
            $validatedData = $request->validate($rules);
            
            // 4. Prepara los datos para la creación
            $dataToCreate = $validatedData;
            $dataToCreate['receipt_path'] = $request->file('receipt_path')->store('receipts', 'public');

            if (Auth::user()->role_id == 1) {
                // Si es admin, usa los datos del formulario
                $dataToCreate['user_id'] = $validatedData['user_id'];
                $dataToCreate['status'] = $validatedData['status'];
            } else {
                // Si es cliente, asigna los datos automáticamente
                $dataToCreate['user_id'] = Auth::id();
                $dataToCreate['status'] = 'pending';
            }

            // 5. Crea el pago
            Payment::create($dataToCreate);

            $message = Auth::user()->role_id == 1 ? '¡Pago registrado exitosamente!' : '¡Tu pago ha sido reportado! Será verificado pronto.';
            
            return response()->json(['success' => true, 'message' => $message]);

        } catch (ValidationException $e) {
            // Si la validación falla, devuelve los errores como JSON
            return response()->json([
                'success' => false,
                'message' => 'Por favor, corrige los errores.',
                'errors' => $e->errors()
            ], 422); // 422 es el código estándar para errores de validación
        } catch (\Exception $e) {
            // Captura cualquier otro error
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado: ' . $e->getMessage()
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
    public function pending(Request $request)
{
    if ($request->ajax()) {
        $payments = Payment::with('user')
            ->where('status', 'pending')
            ->select('payments.*');
        
        // Si no es admin, filtrar solo los pagos del usuario
        if (auth()->user()->role_id != 1) {
            $payments->where('user_id', auth()->id());
        }
        
        return DataTables::of($payments)
            ->addColumn('user_name', function($payment) {
                return $payment->user->first_name . ' ' . $payment->user->last_name;
            })
            ->addColumn('formatted_amount', function($payment) {
                return '$' . number_format($payment->amount, 2);
            })
            ->addColumn('receipt_link', function($payment) {
                return $payment->receipt_path 
                    ? '<a href="'.asset('storage/'.$payment->receipt_path).'" target="_blank">Ver comprobante</a>'
                    : 'Sin comprobante';
            })
            ->addColumn('actions', function($payment) {
                $buttons = '';
                if (auth()->user()->role_id == 1) {
                    $buttons = '
                        <div class="btn-group">
                            <a href="'.route('payments.edit', $payment->id).'" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Revisar
                            </a>
                        </div>
                    ';
                }
                return $buttons;
            })
            ->rawColumns(['receipt_link', 'actions'])
            ->make(true);
    }

    return view('payments.pending');
}

public function overdue(Request $request)
{
    if ($request->ajax()) {
        $payments = Payment::with('user')
            ->where('status', 'overdue')
            ->select('payments.*');
        
        // Si no es admin, filtrar solo los pagos del usuario
        if (auth()->user()->role_id != 1) {
            $payments->where('user_id', auth()->id());
        }
        
        return DataTables::of($payments)
            ->addColumn('user_name', function($payment) {
                return $payment->user->first_name . ' ' . $payment->user->last_name;
            })
            ->addColumn('formatted_amount', function($payment) {
                return '$' . number_format($payment->amount, 2);
            })
            ->addColumn('days_overdue', function($payment) {
                $dueDate = \Carbon\Carbon::parse($payment->month_paid)->endOfMonth();
                return $dueDate->diffInDays(now()) . ' días';
            })
            ->addColumn('receipt_link', function($payment) {
                return $payment->receipt_path 
                    ? '<a href="'.asset('storage/'.$payment->receipt_path).'" target="_blank">Ver comprobante</a>'
                    : 'Sin comprobante';
            })
            ->addColumn('actions', function($payment) {
                $buttons = '';
                if (auth()->user()->role_id == 1) {
                    $buttons = '
                        <div class="btn-group">
                            <a href="'.route('payments.edit', $payment->id).'" class="btn btn-sm btn-warning">
                                <i class="fas fa-exclamation-circle"></i> Regularizar
                            </a>
                            <button class="btn btn-sm btn-danger notify-btn" data-id="'.$payment->id.'">
                                <i class="fas fa-bell"></i> Notificar
                            </button>
                        </div>
                    ';
                } else {
                    $buttons = '
                        <div class="btn-group">
                            <a href="'.route('payments.create').'" class="btn btn-sm btn-primary">
                                <i class="fas fa-money-bill-wave"></i> Pagar
                            </a>
                        </div>
                    ';
                }
                return $buttons;
            })
            ->rawColumns(['receipt_link', 'actions'])
            ->make(true);
    }

    return view('payments.overdue');
    }


public function notifyAllOverdue(Request $request)
{
    // Validar que el usuario sea administrador
    if (auth()->user()->role_id != 1) {
        return response()->json([
            'success' => false,
            'message' => 'No tienes permisos para realizar esta acción'
        ], 403);
    }

    // Obtener el mes actual y el anterior
    $currentMonth = Carbon::now()->format('Y-m');
    $previousMonth = Carbon::now()->subMonth()->format('Y-m');

    // Obtener los pagos morosos con sus usuarios (solo los verificados)
    $overduePayments = Payment::with(['user' => function($query) {
            $query->whereNotNull('email_verified_at');
        }])
        ->where('status', 'overdue')
        ->whereIn('month_paid', [$currentMonth, $previousMonth])
        ->get(); // ¡Importante! get() para obtener la colección

    $notified = 0;
    $failed = 0;

    foreach ($overduePayments as $payment) {
        try {
            // Verificar que el usuario y su email existan
            if (!$payment->user || !filter_var($payment->user->email, FILTER_VALIDATE_EMAIL)) {
                Log::warning("Usuario sin email válido - Pago ID: {$payment->id}");
                $failed++;
                continue;
            }

            // Enviar notificación (versión síncrona)
            Mail::to($payment->user->email)
                ->send(new OverduePaymentNotification($payment));

            // Actualizar registro del pago
            $payment->update([
                'last_notified_at' => now(),
                'notification_count' => $payment->notification_count + 1
            ]);

            $notified++;

        } catch (\Exception $e) {
            Log::error("Error notificando pago ID {$payment->id}: " . $e->getMessage());
            $failed++;
        }
    }

    return response()->json([
        'success' => true,
        'message' => "Notificaciones enviadas: {$notified} exitosas, {$failed} fallidas",
        'data' => [
            'notified' => $notified,
            'failed' => $failed
        ]
    ]);
    }
}