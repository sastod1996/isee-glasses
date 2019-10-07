<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
  protected $fillable = [
    'slug', 'name', 'name_en', 'status', 'primary', 'view', 'premium', 'characteristic_id'
  ];

  public function characteristic()
  {
    return $this->belongsTo('App\Characteristic');
  }

  public function products()
  {
    return $this->belongsToMany('App\Product')->using('App\ProductAttribute');
  }

  public function coupons()
  {
    return $this->morphToMany('App\Coupon', 'couponeable');
  }

  public function attribute_product()
  {
    return $this->hasMany('App\AttributeProduct');
  }

  // public function discounts()
  // {
  //   return $this->morphMany('App\Discount', 'discountable');
  // }
}
