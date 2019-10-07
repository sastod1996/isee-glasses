<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = [
    'code', 'slug', 'name', 'name_en', 'description', 'description_en', 'qty', 'status', 'image', 'price', 'promo', 'color_sizes_status'
  ];

  protected $hidden = ['pivot'];

  public function attributes()
  {
    return $this->belongsToMany('App\Attribute')->withPivot('id', 'status', 'lab_codecolor', 'bridge', 'width', 'height', 'large');
  }

  public function categories()
  {
    return $this->belongsToMany('App\Category');
  }

  public function hasCategory($id)
  {
    return !!$this->categories()->find($id);
  }

  public function orders()
  {
    return $this->belongsToMany('App\Order');
  }

  public function getCharacteristics()
  {
    $attributes = $this->attributes()->with([
      'attribute_product' => function ($query) {
        $query->with([
          'images',
          'cameras',
          'colors' => function ($query) {
            $query->where('stock', '>', 0);
          }
        ])->where('product_id', $this->id);
      }

      // 'attribute_product.images',
      // 'attribute_product.cameras',
      // 'attribute_product.colors'
    ])->get();

    $characteristics = Characteristic::whereIn('id', $attributes->map(function ($attr) {
      return $attr->characteristic_id;
    }))->get();

    $characteristics = $characteristics->map(function ($char) use ($attributes) {
      $characteristic = collect($char);
      $characteristic->put('attributes', $attributes->filter(function ($attr) use ($char) {
        return $attr->characteristic_id === $char->id;
      })->values());
      return $characteristic;
    });

    return $characteristics;
  }

}
