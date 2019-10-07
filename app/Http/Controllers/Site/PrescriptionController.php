<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Prescription;
use Validator;
use Redirect;
use Image;
use Carbon\Carbon;

class PrescriptionController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
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
    $pres = json_decode(json_encode($request->pres));
    $prescription = new Prescription;
    if ($pres->file) {
      $filename = $pres->filename;
      $url = '/storage/prescriptions/'.$filename;
      $path = public_path().$url;
      Image::make(file_get_contents($pres->file))->save($path);
      $prescription->file = $url;
    }else{
      $prescription->file = '';
    }
    $date = Carbon::now()->timezone('America/Lima')->format('d/m/Y H:i:s');
    $prescription->code = getCode('App\Prescription');
    // $prescription->name = isset($pres->name) ? $pres->name : 'Medida '.$date;
    $prescription->name = $pres->name.'Medida '.$date;
    $prescription->esfod = $pres->esfod;
    $prescription->esfoi = $pres->esfoi;
    $prescription->esfdip = $pres->esfdip;
    $prescription->dip = $pres->dip;
    $prescription->cilod = $pres->cilod;
    $prescription->ciloi = $pres->ciloi;
    $prescription->axiod = $pres->axiod;
    $prescription->axioi = $pres->axioi;
    $prescription->addod = $pres->addod;
    $prescription->addoi = $pres->addoi;
    $prescription->description = isset($pres->desc) ? $pres->desc : '';

    $prescription->status = 1;
    $prescription->client_id = $request->cli['cid'];
    $prescription->save();
    $prescription->filename = $pres->filename;
    $prescription->esfod = floatval($prescription->esfod);
    $prescription->esfoi = floatval($prescription->esfoi);
    $prescription->cilod = floatval($prescription->cilod);
    $prescription->ciloi = floatval($prescription->ciloi);
    $prescription->addod = floatval($prescription->addod);
    $prescription->addoi = floatval($prescription->addoi);
    // return response()->json( $prescription );
    return response()->json([
      'prescription' => $prescription,
      'success' => true
    ]);
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
    $pres = json_decode(json_encode($request->pres));
    $prescription = Prescription::find($id);
    if ($pres->file) {
      if (substr($pres->file,0,4) == 'data') {
        $filename = $pres->filename;
        $url = '/storage/prescriptions/'.$filename;
        $path = public_path().$url;
        Image::make(file_get_contents($pres->file))->save($path);
        $prescription->file = $url;
      }
    }else{
      $prescription->file = '';
    }
    $prescription->name = isset($pres->name) ? $pres->name : $filename;
    $prescription->esfod = $pres->esfod;
    $prescription->esfoi = $pres->esfoi;
    $prescription->esfdip = $pres->esfdip;
    $prescription->dip = $pres->dip;
    $prescription->cilod = $pres->cilod;
    $prescription->ciloi = $pres->ciloi;
    $prescription->axiod = $pres->axiod;
    $prescription->axioi = $pres->axioi;
    $prescription->addod = $pres->addod;
    $prescription->addoi = $pres->addoi;
    $prescription->description = isset($pres->desc) ? $pres->desc : '';
    $prescription->save();
    $prescription->filename = isset($pres->file) ? $pres->filename : '';
    $prescription->esfod = floatval($prescription->esfod);
    $prescription->esfoi = floatval($prescription->esfoi);
    $prescription->cilod = floatval($prescription->cilod);
    $prescription->ciloi = floatval($prescription->ciloi);
    $prescription->addod = floatval($prescription->addod);
    $prescription->addoi = floatval($prescription->addoi);

    return response()->json([
      'prescription' => $prescription,
      'success' => true
    ]);
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
