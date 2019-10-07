<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Validator;
use Redirect;

class CategoryController extends Controller
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
    $categories = Category::orderBy('slug')->get();
    return view('admin.categories.index', ['categories' => $categories]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.categories.create');
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
      if(Category::create($this->params($request))){
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('categories.index');
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
    $category = Category::find($id);
    return view('admin.categories.edit', compact('category'));
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
      if(Category::find($id)->update($this->params($request))){
        $request->session()->flash('success', 'Actualizado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('categories.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    Category::destroy($id);
    return redirect()->route('categories.index');
  }

  private function params(Request $request){
    return $request->only('slug', 'name', 'name_en', 'description');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
      'slug' => 'required',
      'name' => 'required'
    ];
    $messages = [
      'slug.required' => 'El slug es requerido',
      'name.required' => 'El nombre es requerido'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
