<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
  * Where to redirect users after login.
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
    $this->redirectTo = URL::previous();
    $this->middleware('guest')->except('logout');
  }

  public function login(Request $request)
  {
    $flag = false;
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      // Authentication passed...
      $flag = true;
    }
    if ($request->ajax()) {
      return response()->json([
        'success' => $flag,
        'user' => Auth::user(),
        'intended' => URL::previous()
      ]);
    } else {
      if (Auth::user()) {
        if (Auth::user()->is_administrator()) {
          return redirect('/admin');
        } else {
          return redirect()->route('profile');
        }
      } else {
        return redirect()->back()->withErrors('status', 'Error');
      }
    }
  }
}
