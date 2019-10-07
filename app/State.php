<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
      'id', 'name', 'name_en'
    ];


  public function order()
  {
        return $this->belongsTo('App\Order');
  }
}
