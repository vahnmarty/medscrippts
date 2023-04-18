<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public function scopeFromEnv($query)
    {
        if(config('app.env') == 'production'){
            return $query->where('prod', true);
        }

        return $query->where('prod', false);
    }

    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }
}
