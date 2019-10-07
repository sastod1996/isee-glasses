<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pack;
use Validator;
use Redirect;

class PackController extends Controller
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
    $packs = Pack::orderBy('slug')->get();
    return view('admin.packs.index', compact('packs'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.packs.create');
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
      if(Pack::create($this->params($request))){
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('packs.index');
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
    $pack = Pack::find($id);
    return view('admin.packs.edit', compact('pack'));
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
      if(Pack::find($id)->update($this->params($request))){
        $request->session()->flash('success', 'Actualizado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('packs.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    Pack::destroy($id);
    return redirect()->route('packs.index');
  }

  private function params(Request $request){
    return $request->only('slug', 'name', 'name_en', 'status');
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
