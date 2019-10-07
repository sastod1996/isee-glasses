<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Attribute;
use App\Characteristic;
use Validator;
use Redirect;

class AttributeController extends Controller
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
    $attributes = Attribute::orderBy('slug')->get();
    // $characteristics = Characteristic::where('slug', '=', 'color')->get();
    $characteristics = Characteristic::whereIn('slug', ['color', 'marca', 'uso', 'material'])->get();
    return view('admin.attributes.index', compact('attributes', 'characteristics'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $characteristics = Characteristic::all();
    return view('admin.attributes.create', compact('characteristics'));
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
      if(Attribute::create($this->params($request))){
        $attribute = Attribute::all()->last();
        $attribute->slug = str_slug($request->name);
        $attribute->save();
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('attributes.index');
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
    $characteristics = Characteristic::all();
    $attribute = Attribute::find($id);
    return view('admin.attributes.edit', compact('attribute', 'characteristics'));
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
      if(Attribute::find($id)->update($this->params($request))){
        $request->session()->flash('success', 'Actualizado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('attributes.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    Attribute::destroy($id);
    return redirect()->route('attributes.index');
  }

  private function params(Request $request)
  {
    return $request->only('slug', 'name', 'name_en', 'status', 'primary', 'view', 'lab_codecolor', 'lab_description', 'premium', 'characteristic_id');
  }

  private function validateRequest(Request $request, $id = null)
  {
    $rules = [
      'name' => 'required | unique:attributes,name,'.$id,
      'status' => 'required',
      'characteristic_id' => 'required'
    ];
    $messages = [
      'name.required' => 'El nombre es requerido',
      'name.unique' => 'El nombre es único',
      'status.required' => 'El estado es requerido',
      'characteristic_id.required' => 'La categoría es requerida'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }

  public function createByChar($id)
  {
    $primaries = [
      [
        'name' => 'Amarillo',
        'value' => 'Amarillo'
      ],
      [
        'name' => 'Azul',
        'value' => 'Azul'
      ],
      [
        'name' => 'Blanco',
        'value' => 'Blanco'
      ],
      [
        'name' => 'Celeste',
        'value' => 'Celeste'
      ],
      [
        'name' => 'Dorado',
        'value' => 'Dorado'
      ],
      [
        'name' => 'Gris',
        'value' => 'Gris'
      ],
      [
        'name' => 'Marrón',
        'value' => 'Marrón'
      ],
      [
        'name' => 'Morado',
        'value' => 'Morado'
      ],
      [
        'name' => 'Naranja',
        'value' => 'Naranja'
      ],
      [
        'name' => 'Negro',
        'value' => 'Negro'
      ],
      [
        'name' => 'Plata',
        'value' => 'Plata'
      ],
      [
        'name' => 'Rojo',
        'value' => 'Rojo'
      ],
      [
        'name' => 'Rosado',
        'value' => 'Rosado'
      ],
      [
        'name' => 'Verde',
        'value' => 'Verde'
      ],
      [
        'name' => 'Vino',
        'value' => 'Vino'
      ]
    ];
    $primaries = json_decode(json_encode($primaries));
    $primaries = collect($primaries);
    $characteristic = Characteristic::find($id);
    return view('admin.attributes.create', compact('characteristic', 'primaries'));
  }

  public function editByChar($char_id, $id)
  {
    $primaries = [
      [
        'name' => 'Amarillo',
        'value' => 'Amarillo'
      ],
      [
        'name' => 'Azul',
        'value' => 'Azul'
      ],
      [
        'name' => 'Blanco',
        'value' => 'Blanco'
      ],
      [
        'name' => 'Celeste',
        'value' => 'Celeste'
      ],
      [
        'name' => 'Dorado',
        'value' => 'Dorado'
      ],
      [
        'name' => 'Gris',
        'value' => 'Gris'
      ],
      [
        'name' => 'Marrón',
        'value' => 'Marrón'
      ],
      [
        'name' => 'Morado',
        'value' => 'Morado'
      ],
      [
        'name' => 'Naranja',
        'value' => 'Naranja'
      ],
      [
        'name' => 'Negro',
        'value' => 'Negro'
      ],
      [
        'name' => 'Plata',
        'value' => 'Plata'
      ],
      [
        'name' => 'Rojo',
        'value' => 'Rojo'
      ],
      [
        'name' => 'Rosado',
        'value' => 'Rosado'
      ],
      [
        'name' => 'Verde',
        'value' => 'Verde'
      ],
      [
        'name' => 'Vino',
        'value' => 'Vino'
      ]
    ];
    $primaries = json_decode(json_encode($primaries));
    $primaries = collect($primaries);
    $characteristic = Characteristic::find($char_id);
    $attribute = Attribute::find($id);
    return view('admin.attributes.edit', compact('characteristic', 'attribute', 'primaries'));
  }

  public function search(Request $request)
  {
    $likes = explode('%20',$request->like);
    $likes = explode(' ',$likes[0]);
    foreach ($likes as $like) {
      $new_like = "(name_en LIKE '%".$like."%') + (name LIKE '%".$like."%')";
      if(isset($db_raw)){
        $db_raw = $db_raw." + ".$new_like;
      }else{
        $db_raw = $new_like;
      }
    }
    $attributes = Attribute::selectRaw("attributes.*,(".$db_raw.") as hits")
                      ->havingRaw('('.$db_raw.') > 0' )
                      ->groupby('id', 'slug', 'name', 'name_en', 'status', 'primary', 'view', 'premium', 'characteristic_id', 'created_at', 'updated_at')
                      ->where('characteristic_id', '=', $request->characteristic_id)
                      ->orderby(DB::raw('hits'), 'DESC')
                      ->get();

    $characteristics = Characteristic::whereIn('slug', ['color', 'marca', 'uso', 'material'])->get();

    return view('admin.attributes.index')->with([
      'newAttributes' => $attributes,
      'characteristics' => $characteristics,
      'charSelected' => $request->characteristic_id
    ]);
  }
}
