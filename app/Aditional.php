<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aditional extends Model
{
  protected $fillable = [
    'name', 'name_en', 'description', 'description_en', 'image'
  ];
}
