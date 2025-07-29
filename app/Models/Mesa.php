<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $fillable = ['nombre'];

    public function comandas()
    {
        return $this->hasMany(Comanda::class);
    }
    // En app/Models/Mesa.php
    public function estaOcupada()
    {
        return $this->comandas()
            ->whereIn('estado', ['pendiente', 'en_cocina', 'preparada'])
            ->exists();
    }
}
