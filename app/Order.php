<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillable = [
    'nro', 'code', 'client_id', 'date_order', 'country', 'city', 'district', 'address', 'postal_code', 'reference', 'subtotal', 'igv', 'price'
  ];

  public function client()
  {
    return $this->belongsTo('App\Client', 'client_id', 'user_id');
  }

  public function coupon()
  {
    return $this->belongsTo('App\Coupon');
  }

  public function products()
  {
    return $this->belongsToMany('App\Product')
    ->withPivot('prod_price', 'color_id', 'color_attr', 'code_color', 'size_id', 'size_attr', 'type_id', 'pack_id', 'pack_price', 'opt_id', 'optcolor_id', 'opt_price',
                'prescription_id', 'pres_esfod', 'pres_esfoi', 'pres_esfdip', 'pres_dip', 'pres_cilod', 'pres_ciloi', 'pres_axiod', 'pres_axioi', 'pres_addod', 'pres_addoi',
                'warranty_id', 'subtotalprice', 'discount', 'totalprice', 'image');
  }

  public function states()
  {
    return $this->belongsToMany('App\State', 'order_state')->withPivot('date');
  }

  public function getCurrentState()
  {
    return $this->states()->where('active',1)->first();
  }
}
