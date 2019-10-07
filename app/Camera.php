<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
  protected $fillable = [
    'url'
  ];

  public function products()
  {
    return $this->hasMany('App\Product');
  }

}
