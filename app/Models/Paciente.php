<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    protected $fillable = ['nombre', 'apellido', 'email', 'telefono'];

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }
}
