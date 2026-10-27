<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use League\CommonMark\Node\Block\Document;

class Persona extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);

    }

    public function proveedore(): HasOne
    {
        return $this->hasOne(Proveedore::class);
    }

    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class);
    }
    
}
