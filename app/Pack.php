<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
  protected $fillable = [
    'slug', 'name', 'name_en', 'description', 'description_en'
  ];

  public function typepacks()
  {
    return $this->hasMany('App\Typepack');
  }
}
