<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
  protected $fillable = [
    'slug', 'currency', 'value'
  ];

  public function user()
  {
    return $this->hasOne('App\User');
  }
}
