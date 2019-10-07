<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Characteristic;
use Validator;
use Redirect;

class CharacteristicController extends Controller
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
    $characteristics = Characteristic::orderBy('slug')->get();
    return view('admin.characteristics.index', ['characteristics' => $characteristics]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.characteristics.create');
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
      if(Characteristic::create($this->params($request))){
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('characteristics.index');
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
    $characteristic = Characteristic::find($id);
    return view('admin.characteristics.edit', compact('characteristic'));
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
      if(Characteristic::find($id)->update($this->params($request))){
        $request->session()->flash('success', 'Actualizado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('characteristics.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    Characteristic::destroy($id);
    return redirect()->route('characteristics.index');
  }

  private function params(Request $request){
    return $request->only('slug', 'name', 'name_en', 'status', 'multiple', 'deep', 'view');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
      'slug' => 'required',
      'name' => 'required',
      'status' => 'required'
    ];
    $messages = [
      'slug.required' => 'El slug es requerido',
      'name.required' => 'El nombre es requerido',
      'status.required' => 'El estado es requerido'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
