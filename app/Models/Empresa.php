<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empresa extends Model
{
    protected $guarded = ['id'];

    protected $table = 'empresa';

    public function divisa(): BelongsTo 
    {
        return $this->belongsTo(Divisa::class); 
    }
}
