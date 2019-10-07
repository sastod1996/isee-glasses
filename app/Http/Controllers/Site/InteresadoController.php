<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mail;
use Validator;
use App\Attribute;
use App\Interesado;
use App\Popup;
use App\Slider;

class InteresadoController extends Controller
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
    $status = true;
    $validator = $this->validateRequest($request);
    if($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput($request->all());
    }else{
      $interesado = Interesado::where('email', '=', $request->email)->first();
      if (!isset($interesado)) {
        if(Interesado::create($this->params($request))){
          try {
            $interesado = Interesado::all()->last();
            $popup = Popup::find($request->popup_id);
            Mail::send('site.mail.interested', array(
              // 'name' => $interesado->name,
              // 'email' => $interesado->email,
              'presentation' => explode('|', $popup->message_presentation),
              'coupon' => $popup->message_coupon,
              // 'code' => $popup->coupon->code,
              // 'percent' => $popup->coupon->percent
            ), function($message) use ($interesado) {
              $message->from('service@isee-glasses.com', 'I-SEE Glasses');
              $message->to('service@isee-glasses.com', 'I-SEE Service');
              $message->to($interesado->email, $interesado->name);
              $message->subject('Isee Glasses agradece su interés');
            });
            \Session::put('modal_status', false);
            $request->session()->flash('success', 'Registro correcto');
          } catch (Exception $e) {
            $request->session()->flash('danger', 'Error, intente de nuevo.');
          }
        }else{
          $request->session()->flash('danger', 'Error, intente de nuevo.');
        }
      } else {
        $request->session()->flash('danger', 'Ya se encuentra registrado.');
      }
    }

    return redirect()->back()->with('modal_status', $status);
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

  private function params(Request $request){
    $request->merge(["telephone" => $request->tele.$request->phone ]);
    return $request->only('name', 'email', 'telephone', 'popup_id');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
    ];
    $messages = [
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
