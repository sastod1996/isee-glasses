<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
  protected $fillable = [
    'user_id'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
