<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
  use Notifiable;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'first_name', 'last_name', 'telephone', 'email', 'role_id', 'password', 'rate_id'
  ];

  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = [
    'password', 'remember_token'
  ];

  public function client()
  {
    return $this->hasOne('App\Client', 'user_id');
  }

  public function administrator()
  {
    return $this->hasOne('App\Administrator');
  }

  public function role()
  {
    return $this->hasOne('App\Role', 'id', 'role_id');
  }

  public function wishes()
  {
    return $this->belongsToMany('App\Product', 'wishes')->select('product_id');
  }

  public function rate()
  {
    return $this->belongsTo('App\Rate');
  }

  public function hasRole($roles)
  {
    $this->have_role = $this->getUserRole();
    // Check if the user is a root account
    if($this->have_role->name == 'Root') {
      return true;
    }
    if(is_array($roles)){
      foreach($roles as $need_role){
        if($this->checkIfUserHasRole($need_role)) {
          return true;
        }
      }
    } else{
      return $this->checkIfUserHasRole($roles);
    }
    return false;
  }

  private function getUserRole()
  {
    return $this->role()->getResults();
  }

  private function checkIfUserHasRole($need_role)
  {
    return (strtolower($need_role)==strtolower($this->have_role->name)) ? true : false;
  }

  public function is_administrator()
  {
    return ($this->role->name == 'Administrator') ? true : false;
  }

  public function is_client(){
    return ($this->role->name == 'Client') ? true : false;
  }

  public function is_affiliate(){
    return ($this->role->name == 'Affiliate') ? true : false;
  }

  public function sendPasswordResetNotification($token){
    // Mail::to(request()->email)->send(new newpassword($token));
    $fullname = $this->first_name.' '.$this->last_name;
    $this->notify(new ResetPasswordNotification($token, $fullname));
  }
}
