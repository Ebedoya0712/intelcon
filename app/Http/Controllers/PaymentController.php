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
            $payments = Payment::with('user')->select('payments.*');
            
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
                    /** @var \App\Models\Payment $payment */
                    $status = $payment->status;
                    
                    // Lógica para asignar clases y texto según el estado
                    switch ($status) {
                        case 'paid':
                        case 'approved': // 'approved' también se considera pagado
                            return '<span class="btn btn-xs btn-success" style="color: white; pointer-events: none;">Pagado</span>';
                        case 'pending':
                            return '<span class="badge badge-warning">Pendiente</span>';
                        case 'overdue':
                            return '<span class="badge badge-danger">Vencido</span>';
                        case 'rejected':
                            return '<span class="badge badge-dark">Rechazado</span>';
                        default:
                            return '<span class="badge badge-secondary">'.ucfirst($status).'</span>';
                    }
                })
                ->addColumn('receipt_link', function($payment) {
                    return $payment->receipt_path 
                        ? '<a href="'.asset('storage/'.$payment->receipt_path).'" target="_blank">Ver comprobante</a>'
                        : 'Sin comprobante';
                })
                ->addColumn('actions', function($payment) {
                    if (auth()->user()->role_id == 1) {
                        $editButton = '<a href="'.route('payments.edit', $payment->id).'" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>';
                        $deleteButton = '<button class="btn btn-sm btn-danger delete-btn" data-id="'.$payment->id.'" title="Eliminar"><i class="fas fa-trash"></i></button>';
                        return '<div class="btn-group">'.$editButton.$deleteButton.'</div>';
                    }
                    return '';
                })
                ->rawColumns(['status_badge', 'receipt_link', 'actions'])
                ->make(true);
        }

        return view('payments.index');
    }

    public function paid(Request $request)
    {
        if ($request->ajax()) {
            $query = Payment::with('user')->whereIn('status', ['paid', 'approved']);

            if (auth()->user()->role_id != 1) {
                $query->where('user_id', auth()->id());
            }
            
            return DataTables::of($query)
                ->addColumn('user_name', fn($payment) => $payment->user->first_name . ' ' . $payment->user->last_name)
                ->addColumn('formatted_amount', fn($payment) => '$' . number_format($payment->amount, 2))
                ->addColumn('status_badge', function($payment) {
                    return '<span class="badge badge-success">Pagado</span>';
                })
                ->addColumn('receipt_link', fn($payment) => $payment->receipt_path ? '<a href="'.asset('storage/'.$payment->receipt_path).'" target="_blank">Ver comprobante</a>' : 'Sin comprobante')
                ->addColumn('actions', function($payment) {
                    if (auth()->user()->role_id == 1) {
                        return '<a href="'.route('payments.edit', $payment->id).'" class="btn btn-sm btn-primary" title="Ver/Editar"><i class="fas fa-edit"></i></a>';
                    }
                    return '';
                })
                ->rawColumns(['status_badge', 'receipt_link', 'actions'])
                ->make(true);
        }

        return view('payments.paid');
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
        if (Auth::user()->role_id != 1) {
            abort(403, 'Acción no autorizada.');
        }
        
        return view('payments.edit', compact('payment'));
    }

    /**
     * Actualiza un pago existente en la base de datos. (Función de Administrador)
     */
    public function update(Request $request, Payment $payment)
    {
        if (Auth::user()->role_id != 1) {
            abort(403, 'Acción no autorizada.');
        }

        // --- INICIO DE LA MODIFICACIÓN ---
        // Ahora solo validamos los campos que el admin puede editar
        $validatedData = $request->validate([
            'status' => 'required|in:paid,pending,overdue,rejected',
            'notes' => 'nullable|string',
        ]);
        // --- FIN DE LA MODIFICACIÓN ---

        $payment->update($validatedData);

        return redirect()->route('payments.pending')->with('success', '¡Pago actualizado exitosamente!');
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


 public function notifyOverdue(Payment $payment)
    {
        try {
            if (!$payment->user || !$payment->user->email) {
                throw new \Exception('El usuario asociado a este pago no tiene un correo electrónico válido.');
            }

            Mail::to($payment->user->email)->send(new OverduePaymentNotification($payment));
            
            return response()->json(['success' => true, 'message' => 'Notificación enviada exitosamente a ' . $payment->user->first_name]);

        } catch (\Exception $e) {
            Log::error("Error al notificar pago ID {$payment->id}: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al enviar la notificación.'], 500);
        }
    }

    /**
     * Notifica a todos los usuarios con pagos vencidos.
     */
    public function notifyAllOverdue(Request $request)
    {
        $overduePayments = Payment::with('user')->where('status', 'overdue')->get();
        $notified = 0;
        $failed = 0;

        foreach ($overduePayments as $payment) {
            try {
                if ($payment->user && $payment->user->email) {
                    Mail::to($payment->user->email)->send(new OverduePaymentNotification($payment));
                    $notified++;
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                Log::error("Error en notificación masiva para pago ID {$payment->id}: " . $e->getMessage());
                $failed++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Proceso completado. Notificaciones enviadas: {$notified}. Fallidas: {$failed}.",
        ]);
    }
}