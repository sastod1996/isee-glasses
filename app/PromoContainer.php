<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoContainer extends Model
{
    protected $fillable = [
        'sections',
    ];

    protected $casts = [
        'sections' => 'array',
    ];
}
