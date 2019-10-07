<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charpack extends Model
{
  protected $fillable = [
    'slug', 'name', 'name_en', 'value'
  ];
}
