<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Type;
use App\Pack;
use App\Typepack;
use Validator;
use Redirect;

class TypepackController extends Controller
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
    $types = Type::all();
    $typepacks = Typepack::all();
    return view('admin.typepacks.index', compact('typepacks', 'types'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $types = Type::all();
    $packs = Pack::all();
    return view('admin.typepacks.create', compact('types', 'packs'));
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
      if(Typepack::create($this->params($request))){
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('typepacks.index');
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
    $types = Type::all();
    $packs = Pack::all();
    $typepack = Typepack::find($id);
    return view('admin.typepacks.edit', compact('types', 'packs', 'typepack'));
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
    // dd($request);
    $validator = $this->validateRequest($request, $id);
    if($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput($request->all());
    }else{
      if(Typepack::find($id)->update($this->params($request))){
        $request->session()->flash('success', 'Actualizado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('typepacks.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    Typepack::destroy($id);
    return redirect()->route('typepacks.index');
  }

  private function params(Request $request){
    return $request->only('type_id', 'pack_id', 'price', 'esfmin', 'esfmax', 'cilmin', 'cilmax', 'material', 'material_en', 'description', 'description_en', 'help', 'help_en');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
      'type_id' => 'required',
      'pack_id' => 'required',
      'description' => 'required',
      'description_en' => 'required',
      'price' => 'required',
      'material' => 'required',
      'material_en' => 'required'
    ];
    $messages = [
      'type_id' => 'El tipo es requerido',
      'pack_id' => 'El paquete es requerido',
      'description.required' => 'La descripción es requerida',
      'description_en.required' => 'El descripción en inglés es requerida',
      'price.required' => 'El precio es requerido',
      'material.required' => 'El material es requerido',
      'material_en.required' => 'El material es requerido'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
