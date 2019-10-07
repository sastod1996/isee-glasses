<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = [
    'slug', 'name', 'name_en', 'description'
  ];

  public function products()
  {
    return $this->belongsToMany('App\Product');
  }
}
