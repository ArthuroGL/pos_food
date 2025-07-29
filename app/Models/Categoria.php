<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre'];
    protected $table = 'categorias'; // Opcional, solo si tu tabla se llama diferente

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
