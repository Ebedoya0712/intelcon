<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'payment_date',
        'month_paid',
        'status',
        'receipt_path',
        'notes',
    ];

    /**
     * Define la relación inversa: un pago pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
