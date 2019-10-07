<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
  protected $fillable = [
    'code', 'affiliate_id', 'status', 'percent', 'limit', 'percent_commission', 'max_commission', 'payment_status', 'start_date', 'end_date', 'count'
  ];

  public function affiliate()
  {
    return $this->belongsTo('App\Client', 'affiliate_id', 'user_id');
  }

  public function orders()
  {
    return $this->hasMany('App\Order');
  }

  public function types()
  {
    return $this->morphedByMany('App\Type', 'couponeable');
  }

  public function attributes()
  {
    return $this->morphedByMany('App\Attribute', 'couponeable');
  }

}
