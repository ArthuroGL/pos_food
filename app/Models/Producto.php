<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable =
    [
        'nombre',
        'precio',
        'descripcion',
        'complementos',
        'categoria_id',
    ];
    protected $casts = [
        'complementos' => 'array',
    ];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function comandas()
    {
        return $this->belongsToMany(Comanda::class, 'comanda_producto')
            ->withPivot('cantidad', 'comentarios')
            ->withTimestamps();
    }
}
