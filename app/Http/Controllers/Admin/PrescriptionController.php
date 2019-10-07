<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Client;
use App\Prescription;
use Validator;
use Redirect;
use Image;

class PrescriptionController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    if (Auth::user()->is_client()) {
      $prescriptions = Prescription::where('client_id', Auth::id())->orderBy('code')->get();
      return view('admin.prescriptions.index', ['prescriptions' => $prescriptions]);
    }else{
      $prescriptions = Prescription::orderBy('code')->get();
      return view('admin.prescriptions.index', ['prescriptions' => $prescriptions]);
    }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $clients = Client::all();
    return view('admin.prescriptions.create', compact('clients'));
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
      if(Prescription::create($this->params($request))){
        $prescription = Prescription::all()->last();
        $prescription->file = $request->file;
        $prescription->save();
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('prescriptions.index');
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
    $prescription = Prescription::find($id);
    $clients = Client::all();
    return view('admin.prescriptions.edit', compact('prescription', 'clients'));
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
      if(Prescription::find($id)->update($this->params($request))){
        $prescription = Prescription::find($id);
        if (!is_null($request->file)) {
          $prescription->file = $request->file;
        }
        $prescription->save();
        $request->session()->flash('prescription-status', 'Prescripción '.$prescription->name.' actualizada correctamente');
        // return Redirect::back()->with('update', 'Actualizado');
      }else{
        $status = false;
        $request->session()->flash('prescription-status', 'Error, intente de nuevo.');
        // return Redirect::back()->with('error_update', 'Error');
      }
    }
    return Redirect::back()->with('update', 'Actualizado');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $prescription = Prescription::find($id);
    $file = $prescription->file;
    Storage::disk('prescriptions')->delete($file);
    Prescription::destroy($id);
    return redirect()->route('prescriptions.index');
  }

  public function download($id)
  {
    $pres = Prescription::findOrFail($id);
    // dd('holi');
    return response()->file($pres->file);
  }

  private function params(Request $request){
    if ( !is_null($request->file) && !is_string($request->file)) {
      $file = $request->file;
      $filename = $file->getClientOriginalName();
      $route = $request->client_id.'/'.$filename;
      Storage::disk('prescriptions')->put($route, file_get_contents($file));
      $request->file = '/storage/prescriptions/'.$route;
    }
    if ( !is_null($request->status)){
      $request->merge(["status" => ($request->status == 'true' ? true : false) ]);
    }else {
      $request->merge(["status" => false ]);
    }
    return $request->only('code', 'name', 'esfod', 'esfoi', 'esfdip', 'dip', 'cilod', 'ciloi', 'axiod', 'axioi', 'addod', 'addoi', 'description', 'file', 'status', 'client_id');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
      'code' => 'required | unique:prescriptions,code,'.$id,
      'name' => 'required'
    ];
    $messages = [
      'code.required' => 'El código es requerido',
      'name.required' => 'El nombre es requerido'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
