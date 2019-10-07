<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enterprise;
use Validator;
use Redirect;

class EnterpriseController extends Controller
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
    $enterprises = Enterprise::all();
    return view('admin.enterprises.index', ['enterprises' => $enterprises]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.enterprises.create');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    try {
      $enterprise = new Enterprise;
      $enterprise->create($request->all());
      return redirect()->route('enterprises.index');
    } catch (Exception $e) {
      $request->session()->flash('error', 'Error al crear empresa');
      return redirect()->back();
    }
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
    $enterprise = Enterprise::find($id);
    return view('admin.enterprises.edit', compact('enterprise'));
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
    $enterprise = Enterprise::find($id);
    try {
      $enterprise->update($request->all());
      return redirect()->route('enterprises.index');
    } catch (Exception $e) {
      $request->session()->flash('error', 'Error al actualizar empresa');
      return redirect()->back();
    }
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
}
