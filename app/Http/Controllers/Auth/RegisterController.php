<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Client;
use App\User;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
  * Where to redirect users after registration.
  *
  * @var string
  */
  protected $redirectTo = '/';

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
  * Get a validator for an incoming registration request.
  *
  * @param  array  $data
  * @return \Illuminate\Contracts\Validation\Validator
  */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'role_id' => 'required',
      'password' => 'required|string|min:6|confirmed',
      'dni' => 'required|max:10',
    ]);
  }

  /**
  * Create a new user instance after a valid registration.
  *
  * @param  array  $data
  * @return User
  */
  protected function create(array $data)
  {

    $user = User::create([
    'first_name' => $data['first_name'],
    'last_name' => $data['last_name'],
    'telephone' => $data['telephone'],
    'email' => $data['email'],
    'role_id' => $data['role_id'],
    'rate_id' => $data['country'] == 'Peru' ? 1 : 2,
    'password' => bcrypt($data['password']),
    ]);

    $client = Client::create([
    'user_id' => $user->id,
    'country' => $data['country'],
    'city' => $data['city'],
    'code' => $data['code'],
    'district' => $data['district'],
    'address' => $data['address'],
    'reference' => $data['reference'],
    'dni' => $data['dni'],
    ]);

    try {
      Mail::send('site.mail.welcome', $data, function($message) use ($data) {
        $message->from('service@isee-glasses.com', 'I-SEE Service');
        $message->to('service@isee-glasses.com', 'I-SEE Service');
        $message->to($data['email'], $data['first_name']);
        $message->subject('BIENVENIDO');
      });
      $status = true;
    } catch (Exception $e) {
      $status = false;
    }

    return $user;
  }
}
