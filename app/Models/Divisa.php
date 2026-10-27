<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Divisa extends Model
{
    use HasFactory;

    public function divisa(): HasOne
    {
        return $this->hasOne(Empresa::class);
    }
}
