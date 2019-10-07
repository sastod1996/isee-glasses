<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorSize extends Model
{
  protected $table = 'color_sizes';

  protected $fillable = [
    'color_id', 'size_id', 'stock'
  ];
}
