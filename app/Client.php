<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  protected $fillable = [
    'user_id', 'country', 'city', 'code', 'district', 'address', 'reference', 'status_affiliate', 'dni', 'facebook', 'instagram', 'twitter', 'youtube', 'ally', 'enterprise_id'
  ];

  public function prescriptions()
  {
    return $this->hasMany('App\Prescription');
  }

  public function user()
  {
    return $this->belongsTo('App\User','user_id', 'id');
  }

  public function enterprise()
  {
    return $this->belongsTo('App\Enterprise','enterprise_id');
  }

  public function affiliate()
  {
    // return $this->hasOne('App\Affiliate', 'client_id');
  }

  public function orders()
  {
    return $this->hasMany('App\Order');
  }
}
