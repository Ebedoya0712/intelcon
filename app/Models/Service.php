<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'speed_mbps',
        'price',
        'status',
    ];

    /**
     * Define la relación: un plan de servicio puede tener muchos usuarios.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'service_user')
                    ->withPivot('start_date', 'end_date', 'status')
                    ->withTimestamps();
    }

}
