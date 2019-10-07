<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Attribute;
use App\Client;
use App\Rate;
use App\Slider;
use App\Popup;
use Carbon\Carbon;
use App\PromoContainer;

class HomeController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $now = Carbon::now()->format('Y-m-d');
    if (\Session::has('modal_status')) {
      $status = \Session::get('status');
      if (!\Session::get('status')) {
        \Session::put('modal_status', true);
      }
    } else {
      $status = true;
    }
    $popup = Popup::where([
      ['status', '=', 1],
      ['end_date', '>=', $now]
    ])->first();
    // dd(Popup::all());
    // dd($now);
    $sliders = Slider::where('status', '=', 1)->get();
    $premiums = Attribute::where('premium', '=', '1')->get();
    $words = "";
    foreach ($premiums as $premium) {
      $words = $words.$premium->slug.',';
    }

    $promotions = PromoContainer::firstOrCreate([], ['sections' => []]);
    return view('site.home.index', compact('sliders', 'words', 'popup', 'status', 'promotions'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }

  public function changeRate($slug)
  {
    if (Auth::check()) {
      $rate = Rate::where('slug', '=', $slug)->first();
      $user = Auth::user();
      $user->rate_id = $rate->id;
      $user->save();
    } else {
      session()->put('rateslug', $slug);
    }
    return redirect()->back();
  }
}
