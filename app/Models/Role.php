<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false; // La tabla de roles no necesita timestamps

    protected $fillable = ['name'];

    /**
     * Un rol puede tener muchos usuarios.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

