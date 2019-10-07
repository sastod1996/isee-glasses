<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
  protected $fillable = [
    'slug', 'name', 'name_en', 'description', 'description_en', 'price', 'time', 'period', 'period_en', 'help', 'help_en'
  ];
}
