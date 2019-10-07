<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{

  protected $fillable = [
    'code', 'name', 'esfod', 'esfoi', 'esfdip', 'dip', 'cilod', 'ciloi', 'axiod', 'axioi', 'addod', 'addoi', 'description', 'file', 'filename', 'status', 'client_id'
  ];

  public function client()
  {
    return $this->belongsTo('App\Client', 'client_id', 'id');
  }

  public function orders()
  {
    return $this->hasMany('App\Order');
  }
}
