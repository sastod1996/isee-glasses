<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
  protected $fillable = [
    'slug', 'name', 'name_en', 'status', 'order', 'multiple', 'deep', 'view'
  ];

  public function attributes()
  {
    if ($this->slug == 'marca') {
      return $this->hasMany('App\Attribute')->where([['status', '=', 1]])->orderBy('premium','desc')->orderBy('slug');
    }else{
      return $this->hasMany('App\Attribute')->where([['status', '=', 1], ['view', '=', 1]]);
    }
  }
}
