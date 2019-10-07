<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interesado extends Model
{
  protected $fillable = [
    'name', 'email', 'telephone', 'popup_id'
  ];

  public function popup()
  {
    return $this->belongsTo('App\Popup');
  }

}
