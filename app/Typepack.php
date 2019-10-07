<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typepack extends Model
{
  protected $fillable = [
    'type_id', 'pack_id', 'price', 'esfmin', 'esfmax', 'cilmin', 'cilmax', 'material', 'material_en', 'description', 'description_en', 'help', 'help_en'
  ];

  protected $table = 'type_packs';

  public function pack()
  {
    return $this->belongsTo('App\Pack');
  }

  public function type()
  {
    return $this->belongsTo('App\Type');
  }
}
