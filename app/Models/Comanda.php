<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comanda extends Model
{
    protected $fillable = ['mesa_id', 'estado'];

    const ESTADOS = ['pendiente', 'en_cocina', 'lista', 'entregada', 'cancelada'];
    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
    // En app/Models/Comanda.php
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'comanda_producto')
            ->withPivot('cantidad', 'comentarios', 'estado', 'entregado', 'created_at', 'updated_at');
    }
    protected $casts = [
        'status' => 'boolean',
    ];
}
