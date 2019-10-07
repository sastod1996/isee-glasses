<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
  protected $fillable = [
    'id', 'slug', 'name', 'name_en', 'description', 'description_en', 'image'
  ];

  public function coupons()
  {
    return $this->morphToMany('App\Coupon', 'couponeable');
  }

  public function typepacks()
  {
    return $this->hasMany('App\Typepack');
  }

  // public function discounts()
  // {
  //   return $this->morphMany('App\Discount', 'discountable');
  // }
}
