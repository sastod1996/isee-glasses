<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
  protected $fillable = [
    'client_id'
  ];

  public function client()
  {
    return $this->hasOne('App\Client', 'user_id', 'client_id');
  }

  public function coupons()
  {
    return $this->hasMany('App\Coupon', 'affiliate_id', 'client_id');
  }
}
