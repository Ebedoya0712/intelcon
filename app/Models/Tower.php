<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tower extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'municipality_id',
        'address',
        'capacity',
        'status',
    ];

    /**
     * Una torre pertenece a un municipio.
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Accesor para obtener la ciudad a través del municipio.
     * Permite usar $tower->city
     */
    public function getCityAttribute()
    {
        // Se usa optional() para evitar errores si una relación no existe.
        return optional($this->municipality)->city;
    }

    /**
     * Accesor para obtener el estado a través de la ciudad y el municipio.
     * Permite usar $tower->state
     */
    public function getStateAttribute()
    {
        return optional(optional($this->municipality)->city)->state;
    }
}
