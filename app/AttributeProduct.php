<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributeProduct extends Model
{
  protected $table = 'attribute_product';


  protected $fillable = [
    'product_id', 'attribute_id', 'status', 'lab_codecolor', 'bridge', 'width', 'height', 'large'
  ];

  public function images()
  {
    return $this->hasMany('App\Image');
  }

  public function cameras()
  {
    return $this->hasMany('App\Camera');
  }

  public function colors()
  {
    return $this->hasMany('App\ColorSize', 'size_id', 'id');
  }

}
