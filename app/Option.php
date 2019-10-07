<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
  protected $fillable = [
    'name', 'name_en', 'description', 'description_en', 'image'
  ];
}
