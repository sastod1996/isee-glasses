<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
  protected $fillable = [
    'slug', 'name', 'title', 'text_main', 'text_secondary', 'text_close', 'status', 'image', 'end_date', 'message_presentation', 'message_coupon', 'coupon_id'
  ];

  public function coupon()
  {
    return $this->belongsTo('App\Coupon');
  }

  public function interesados()
  {
    return $this->hasMany('App\Interesado');
  }

}
