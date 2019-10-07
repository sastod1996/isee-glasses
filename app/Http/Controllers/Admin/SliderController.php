<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Slider;
use Validator;
use Redirect;
use Image;
use File;

class SliderController extends Controller
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
    $sliders = Slider::all();
    return view('admin.sliders.index', ['sliders' => $sliders]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.sliders.create');
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
      if(Slider::create($this->params($request))){
        $slider = Slider::all()->last();
        $slider->image = $request->image;
        $slider->save();
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('sliders.index');
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
    $slider = Slider::find($id);
    return view('admin.sliders.edit', compact('slider'));
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
      if(Slider::find($id)->update($this->params($request))){
        $slider = Slider::find($id);
        $slider->image = $request->image;
        $slider->save();
        $request->session()->flash('success', 'Actualizado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('sliders.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $slide = Slider::find($id);
    $parts = explode('/', $slide->image);
    Storage::disk('sliders')->delete(end($parts));
    Slider::destroy($id);
    return redirect()->route('sliders.index');
  }

  private function params(Request $request){
    if ( !is_null($request->image) && !is_string($request->image)) {
      $image = $request->image;
      $name = $image->getClientOriginalName();
      Storage::disk('sliders')->put('/'.$name, file_get_contents($image));
      $request->image = '/storage/sliders/'.$name;
    }
    return $request->only('image', 'status');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
      'image' => 'required'
    ];
    $messages = [
      'image.required' => 'La imagen es requerida'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
