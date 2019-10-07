<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Coupon;
use App\Popup;
use App\Interesado;
use Image;
use File;

class PopupController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('administrator');
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $popups = Popup::orderBy('slug')->get();
    return view('admin.popups.index', compact('popups'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $coupons = Coupon::all();
    return view('admin.popups.create', compact('coupons'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $validator = $this->validateRequest($request);
    if($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput($request->all());
    }else{
      try {
        Popup::create($this->params($request));
        $popup = Popup::all()->last();
        $popup->image = $request->image;
        $popup->save();
        $request->session()->flash('success', 'Creado correctamente');
      } catch (Exception $e) {
        return redirect()->back();
      }
    }
    return redirect()->back();
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $popup = Popup::find($id);
    return view('admin.popups.show', compact('popup'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $popup = Popup::find($id);
    $coupons = Coupon::all();
    return view('admin.popups.edit', compact('popup', 'coupons'));
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
    $validator = $this->validateRequest($request, $id);
    if($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput($request->all());
    }else{
      try {
        Popup::find($id)->update($this->params($request, $id));
        $popup = Popup::find($id);
        $popup->image = $request->image;
        $popup->save();
        $request->session()->flash('success', 'Actualizado correctamente');
      } catch (Exception $e) {
        return redirect()->back();
      }
    }
    return redirect()->back();
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

  private function params(Request $request, $id = null)
  {
    $flag = true;
    if ( isset($request->image)) {
      $p = Popup::find($id);
      if (isset($p) ) {
        if ($p->image == $request->image) {
          $flag = false;
        }
      }
      if ($flag) {
        $image = $request->image;
        $name = $image->getClientOriginalName();
        $name = str_slug(substr(strtolower($name), 0, -4));
        $extension = $image->getClientOriginalExtension();
        $real_name = $name.'.'.$extension;
        Storage::disk('popups')->put('/'.$real_name, file_get_contents($image));
        $request->image = '/storage/popups/'.$real_name;
      }
    }

    if ($id == null) {
      if ($request->status) {
        $popups = Popup::all();
        foreach ($popups as $popup) {
          $popup->update(['status' => 0]);
        }
      }
      $request->merge(["slug" => str_slug($request->name) ]);
      return $request->only('slug', 'name', 'title', 'text_main', 'text_secondary', 'text_close', 'status', 'image', 'message_presentation', 'message_coupon', 'end_date', 'coupon_id');
    } else {
      if ($request->status) {
        $popups = Popup::all()->except($id);
        foreach ($popups as $popup) {
          $popup->update(['status' => 0]);
        }
      }
      return $request->only('name', 'title', 'text_main', 'text_secondary', 'text_close', 'status', 'image', 'message_presentation', 'message_coupon', 'end_date', 'coupon_id');
    }
  }

  private function validateRequest(Request $request, $id = null)
  {
    $rules = [
    ];
    $messages = [
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
