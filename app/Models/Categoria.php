<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['caracteristica_id'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_producto', 'categoria_id', 'producto_id');
    }

    public function caracteristica(): BelongsTo
    {
        return $this->belongsTo(Caracteristica::class, 'caracteristica_id');
    }

    
}
