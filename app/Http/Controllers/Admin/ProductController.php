<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Attribute;
use App\Category;
use App\Characteristic;
use App\Product;
use App\AttributeProduct;
use Validator;
use Redirect;
use Image;
use File;
use Route;

class ProductController extends Controller
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
    // $products = Product::orderBy('updated_at', 'desc')->get();
    $products = Product::orderBy('code', 'asc')->paginate(10);
    // $products = $products->map(function($product){
    $products->getCollection()->transform(function ($product) {
      $product->colors = DB::table('attribute_product')
                            ->join('attributes', 'attributes.id', '=', 'attribute_product.attribute_id')
                            ->join('products', 'products.id', '=', 'attribute_product.product_id')
                            ->join('characteristics', 'characteristics.id', '=', 'attributes.characteristic_id')
                            ->where('characteristics.slug', '=', 'color')
                            ->where('attribute_product.product_id', '=', $product->id)
                            ->select('attributes.*', 'attribute_product.id as attribute_product_id')
                            ->get();
      $product->sizes = DB::table('attribute_product')
                            ->join('attributes', 'attributes.id', '=', 'attribute_product.attribute_id')
                            ->join('products', 'products.id', '=', 'attribute_product.product_id')
                            ->join('characteristics', 'characteristics.id', '=', 'attributes.characteristic_id')
                            ->where('characteristics.slug', '=', 'tamanio')
                            ->where('attribute_product.product_id', '=', $product->id)
                            ->select('attributes.*', 'attribute_product.id as attribute_product_id')
                            ->get();
      $product->color_sizes = DB::table('attribute_product')
                                ->join('products', 'attribute_product.product_id', '=', 'products.id')
                                ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                ->where('attribute_product.product_id', '=', $product->id)
                                ->where('characteristics.slug', '=', 'tamanio')
                                ->select('attributes.*', 'attribute_product.*', 'attribute_product.id as attribute_product_id')
                                ->get();
      $product->color_sizes = $product->color_sizes->map(function($color_size) use ($product) {
        $color_size->colors = DB::table('color_sizes')
                                ->join('attribute_product', 'color_sizes.color_id', '=', 'attribute_product.id')
                                ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                ->where('color_sizes.size_id', '=', $color_size->attribute_product_id)
                                ->select('attributes.*', 'attribute_product.*', 'attribute_product.id as attribute_product_id', 'color_sizes.stock as stock', 'color_sizes.id as color_size_id')
                                ->get();
        return $color_size;
      });
      return $product;
    });

    // $products = $products->paginate(20);
    // return response()->json($products);
    return view('admin.products.index', ['products' => $products  ]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $characteristics = characteristic::all();
    $characteristics = $characteristics->map(function($characteristic) {
      $characteristic->attributes = DB::table('characteristics')
                                      ->join('attributes', 'characteristics.id', '=', 'attributes.characteristic_id')
                                      ->where('attributes.characteristic_id', '=', $characteristic->id)
                                      ->get();
      return $characteristic;
    });

    $categories = Category::all();
    return view('admin.products.create', compact('characteristics', 'categories'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    // holis
    $validator = $this->validateRequest($request);
    if($validator->fails()) {
      return Redirect::back()->withErrors($validator)->withInput($request->all());
    } else {
      if(Product::create($this->params($request))) {
        $categories = $request->categories;
        $chars = $request->chars;
        $codes = $request->codes;
        $product = Product::all()->last();
        $product->slug = str_slug($request->code);
        $product->image = $request->image;
        $product->save();
        $product->categories()->sync($categories);

        foreach ($chars as $characteristic) {
          $loop = 0;
          foreach ($characteristic as $attribute) {
            $attr = Attribute::find($attribute);

            $attr_prod_id =  DB::table('attribute_product')
                                ->insertGetId([
                                  'product_id' => $product->id,
                                  'attribute_id' => $attr->id
                                ]);
            $char = Characteristic::find($attr->characteristic_id);

            if ($char->slug == 'color') {
              DB::table('attribute_product')
                  ->where('id', $attr_prod_id)
                  ->update(['lab_codecolor' => $codes[$loop]]);
              $loop = $loop+1;

              //3 img por color
              $images = $request->imgColor[$attr->slug];
              if (!is_null($images)) {
                $count = 1;
                foreach ($images as $image) {
                  $extension  = $image->getClientOriginalExtension();
                  $url = $product->slug.'/images/'.$attr->slug.'/'.$product->slug.'-'.$count.'.'.$extension;
                  Storage::disk('products')->put($url, file_get_contents($image));
                  DB::table('images')
                      ->insertGetId([
                        'url' => '/storage/products/'.$url,
                        'attribute_product_id' => $attr_prod_id
                      ]);
                  $count = $count+1;
                }
              }
              //Imagen del probador
              $cameras = $request->camera[$attr->slug];
              if(!is_null($cameras)) {
                foreach ($cameras as $camera) {
                  $extension  = $camera->getClientOriginalExtension();
                  $url = $product->slug.'/cameras/'.$attr->slug.'/'.$product->slug.'.'.$extension;
                  Storage::disk('products')->put($url, file_get_contents($camera));
                  DB::table('cameras')
                      ->insertGetId([
                      'url' => '/storage/products/'.$url,
                      'attribute_product_id' => $attr_prod_id
                      ]);
                }
              }
            }
            if ($char->slug == 'tamanio') {
              $tam = $request->tamanios[$attr->slug];
              if (!is_null($tam)) {
                DB::table('attribute_product')
                    ->where('id', $attr_prod_id)
                    ->update([
                    'bridge' => $tam['bridge'],
                    'width' => $tam['width'],
                    'height' => $tam['height'],
                    'large' => $tam['large']
                    ]);
              }
            }
          }
        }

        $product_pos = Product::where('code', '<=', $product->code)->orderBy('code', 'asc')->count();
        $page = ceil($product_pos/10);
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $page = 1;
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect(url('admin/products?page='.$page));
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($slug)
  {
    $product = Product::where('slug', '=', $slug)->first();
    $product->characteristics = DB::table('attribute_product')
                                  ->distinct()
                                  ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                  ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                  ->where('attribute_product.product_id', '=', $product->id)
                                  ->where('characteristics.status', '=', 1)
                                  ->select('characteristics.*')
                                  ->get();
    $product->characteristics = $product->characteristics->map(function ($characteristic) use ($product) {
      $characteristic->attributes = DB::table('attributes')
                                      ->distinct()
                                      ->join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
                                      ->where('attribute_product.product_id', '=', $product->id)
                                      ->where('attributes.characteristic_id', '=', $characteristic->id)
                                      ->select('attributes.*', 'attribute_product.id as attribute_product_id', 'attribute_product.*')
                                      ->get();
      return $characteristic;
    });

    $product->sizes = DB::table('attribute_product')
                        ->join('attributes', 'attributes.id', '=', 'attribute_product.attribute_id')
                        ->join('products', 'products.id', '=', 'attribute_product.product_id')
                        ->join('characteristics', 'characteristics.id', '=', 'attributes.characteristic_id')
                        ->where('characteristics.slug', '=', 'tamanio')
                        ->where('attribute_product.product_id', '=', $product->id)
                        ->select('attributes.*', 'attribute_product.*', 'attribute_product.id as attribute_product_id')
                        ->get();
    // return response()->json($product);
    return view('admin.products.show', ['product' => $product]);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id){
    $backTo = url()->previous();
    $characteristics = characteristic::all();
    $characteristics = $characteristics->map(function($characteristic) {
      $characteristic->attributes = DB::table('characteristics')
                                      ->join('attributes', 'characteristics.id', '=', 'attributes.characteristic_id')
                                      ->where('attributes.characteristic_id', '=', $characteristic->id)
                                      ->get();
      return $characteristic;
    });

    $product = Product::with('attributes', 'categories')->where('id', $id)->firstOrFail();
    $product->characteristics = DB::table('attribute_product')
                                  ->distinct()
                                  ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                  ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                  ->where('attribute_product.product_id', '=', $product->id)
                                  ->where('characteristics.status', '=', 1)
                                  ->select('characteristics.*')
                                  ->get();
    $product->characteristics = $product->characteristics->map(function ($characteristic) use ($product) {
      $characteristic->attributes = DB::table('attributes')
                                      ->distinct()
                                      ->join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
                                      ->where('attribute_product.product_id', '=', $product->id)
                                      ->where('attributes.characteristic_id', '=', $characteristic->id)
                                      ->select('attributes.*', 'attribute_product.id as attribute_product_id')
                                      ->get();
      $characteristic->attributes = $characteristic->attributes->map(function ($attribute) use ($product, $characteristic) {
        $attribute->images = DB::table('images')
                                ->distinct()
                                ->join('attribute_product', 'images.attribute_product_id', '=', 'attribute_product.id')
                                ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                ->where('characteristics.id', '=', $characteristic->id)
                                ->where('attribute_product.product_id', '=', $product->id)
                                ->where('images.attribute_product_id', '=', $attribute->attribute_product_id)
                                ->select('images.*')
                                ->get();
        $attribute->cameras = DB::table('cameras')
                                ->distinct()
                                ->join('attribute_product', 'cameras.attribute_product_id', '=', 'attribute_product.id')
                                ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                ->where('characteristics.id', '=', $characteristic->id)
                                ->where('attribute_product.product_id', '=', $product->id)
                                ->where('cameras.attribute_product_id', '=', $attribute->attribute_product_id)
                                ->select('cameras.*')
                                ->get();
        $attribute->colors = DB::table('color_sizes')
                                ->distinct()
                                // ->join('attribute_product', 'color_sizes.color_id', '=', 'attribute_product.id')
                                ->join('attribute_product', 'color_sizes.size_id', '=', 'attribute_product.id')
                                ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                ->where('color_sizes.size_id', '=', $attribute->attribute_product_id)
                                // ->where('attributes.slug', '=', '')
                                ->select('color_sizes.*')
                                ->get();
        return $attribute;
      });
      return $characteristic;
    });

    // return response()->json($product);
    $categories = Category::all();
    return view('admin.products.edit', compact('product', 'characteristics', 'categories', 'backTo'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id){
    $validator = $this->validateUpdate($request, $id);
    if($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput($request->all());
    }else{
      // dd($request);
      if(Product::find($id)->update($this->params($request))){
        // Imagen por default
        $product = Product::find($id);
        $product->update([ 'image' => $request->image ]);
        $categories = $request->categories;
        $product->categories()->sync($categories);

        // Tamaños del product
        foreach ($request->attr_slugs as $attr_slug) {
          $attr_prod_id = $request->attr_prod_id;
          $tam = $request->tamanios[$attr_slug];
          if (!is_null($tam)) {
            DB::table('attribute_product')
              ->where('id', $attr_prod_id)
              ->update([
                'bridge' => $tam['bridge'],
                'width' => $tam['width'],
                'height' => $tam['height'],
                'large' => $tam['large']
              ]);
          }
        }

        //Actualización de imagenes del producto interno
        if (!is_null($request->imgColor)) {
          foreach ($request->imgColor as $color => $color_images) {
            $directory = '/'.$product->slug.'/images'.'/'.$color;
            $index = 1;
            $attr_prod_id = $product->attributes->where('slug','=', $color)
                                                ->where('characteristic_id', '=', 6) //para asegurarnos que sea color
                                                ->first()
                                                ->pivot->id;  //id de la tabla attribute_product
            foreach ($color_images as $image) {
              //Remover imagen anterior
              $oldimages = Storage::Files('/public/products'.$directory);
              foreach ($oldimages as $oldimage) {
                if (pathinfo($oldimage)['filename'] == $product->slug.'-'.$index) {
                  Storage::delete($oldimage);
                }
              }

              // Almacenar nueva imagen
              $extension  = $image->getClientOriginalExtension();
              $url = $directory.'/'.$product->slug.'-'.$index.'.'.$extension;
              Storage::disk('products')->put($url, file_get_contents($image));

              // Actualizar ruta en DB
              DB::table('images')
                ->where('attribute_product_id', $attr_prod_id)
                ->where('url', 'like', '%'.$product->slug.'-'.$index.'%')
                ->update([ 'url' => '/storage/products'.$url ]);

              $index++;
            }
          }
        }

        //Actualización de imagenes de la camara
        if (!is_null($request->camera)) {
          foreach ($request->camera as $key => $camera) {
            $slugcolor = $key;
            $attr_prod_id = $product->attributes->where('slug','=', $slugcolor)
                                                ->where('characteristic_id', '=', 6) //para asegurarnos que sea color
                                                ->first()
                                                ->pivot->id;  //id de la tabla attribute_product
            //Remover imagen anterior
            $oldcameras = Storage::Files('/public/products/'.$product->slug.'/cameras'.'/'.$slugcolor);
            foreach ($oldcameras as $oldcamera) {
              Storage::delete($oldcamera);
            }

            //Almacenar nueva imagen
            $extension  = $camera[0]->getClientOriginalExtension();
            $path = '/'.$product->slug.'/cameras'.'/'.$slugcolor.'/'.$product->slug.'.'.$extension;
            Storage::disk('products')->put($path, file_get_contents($camera[0]));

            // Actualizar ruta en DB
            DB::table('cameras')
              ->where('attribute_product_id', $attr_prod_id)
              ->update([ 'url' => '/storage/products'.$path ]);
          }
        }

        $request->session()->flash('success', 'Actualizado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect($request->backTo);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(Request $request, $id)
  {
    $product = Product::find($id);

    if ($product->status == 1) {
      $product->update(['status' => 0]);
      $request->session()->flash('success', 'Producto desactivado correctamente');
    }else{
      $product->update(['status' => 1]);
      $request->session()->flash('success', 'Producto activado correctamente');
    }

    return redirect()->route('products.index');
  }

  private function params(Request $request){
    if ( !is_null($request->image) && !is_string($request->image)) {
      $slug = str_slug($request->code);
      $directory = '/products';
      $image = $request->image;
      $extension = $image->getClientOriginalExtension();
      $filename  = $slug.'.'.$extension;
      if (!Storage::exists($directory.'/'.$slug.'/'.$filename.'.jpg')) {
        Storage::disk('products')->makeDirectory($slug);
      }
      $oldimages = Storage::Files('/public/products/'.$slug);
      foreach ($oldimages as $oldimage) {
        Storage::delete($oldimage);
      }
      Storage::disk('products')->put('/'.$slug.'/'.$filename, file_get_contents($image));
      $request->image = '/storage/products/'.$slug.'/'.$filename;
    }
    return $request->only('name', 'name_en', 'code', 'description', 'description_en', 'price', 'promo', 'qty', 'status', 'image', 'color_sizes_status');
  }

  private function validateRequest(Request $request, $id=null){
    $rules = [
      'code' => 'required | unique:products,code,'.$id,
      'name' => 'required',
      'image' => 'required',
      'price' => 'required',
      // 'chars' => 'required',

      'chars.marca' => 'required',
      'chars.tamanio' => 'required',
      'chars.uso' => 'required',
      'chars.montura' => 'required',
      'chars.forma' => 'required',
      'chars.color' => 'required',
      'chars.genero' => 'required',
      'chars.tipo' => 'required',
      'chars.material' => 'required'

      // 'chars.medidas' => 'required',
    ];
    $messages = [
      'code.required' => 'El código es requerido',
      'code.unique' => 'El código es único',
      'name.required' => 'El nombre es requerido',
      'image.required' => 'La imagen es requerida',
      'price.required' => 'El precio es requerido',
      // 'chars.required' => 'Debe asignar características al producto',

      'chars.marca.required' => 'Debe seleccionar una marca',
      'chars.tamanio.required' => 'Debe seleccionar al menos un tamaño',
      'chars.uso.required' => 'Debe seleccionar un uso',
      'chars.montura.required' => 'Debe seleccionar una montura',
      'chars.forma.required' => 'Debe seleccionar una forma',
      'chars.color.required' => 'Debe seleccionar al menos un color y sus imágenes',
      'chars.genero.required' => 'Debe seleccionar un género',
      'chars.tipo.required' => 'Debe seleccionar un tipo',
      'chars.material.required' => 'Debe seleccionar un material'

      // 'chars.medidas.required' => 'Debe ingresar al menos una medida',
    ];
    return Validator::make($request->all(), $rules, $messages);
  }

  private function validateUpdate(Request $request, $id){
    $rules = [
      'code' => 'required | unique:products,code,'.$id,
      'name' => 'required',
      'image' => 'required',
      'price' => 'required',
    ];
    $messages = [
      'code.required' => 'El código es requerido',
      'code.unique' => 'El código es único',
      'name.required' => 'El nombre es requerido',
      'image.required' => 'La imagen es requerida',
      'price.required' => 'El precio es requerido',
    ];
    return Validator::make($request->all(), $rules, $messages);
  }

  public function asign(Request $request, $slug)
  {
    $sizes = $request->sizes;
    for ($i=0; $i < count($sizes); $i++) {
      $data = $sizes[$i];
      for ($j=0; $j < count($data); $j++) {
        if (isset($data[$j]['size_id']) && isset($data[$j]['color_id']) && isset($data[$j]['stock'])) {
          if ($data[$j]['size_id'] > 0 && $data[$j]['color_id'] > 0) {
            $product = Product::where('slug', '=', $slug)->first();
            $product->status = 1;
            $product->color_sizes_status = true;
            $product->save();
            DB::table('color_sizes')
                ->insert([
                  'size_id' => $data[$j]['size_id'],
                  'color_id' => $data[$j]['color_id'],
                  'stock' => $data[$j]['stock']
                ]);
          }
        }
      }
    }
    return back()->withInput();
  }

  public function editAsign(Request $request, $slug)
  {
    $sizes = $request->sizes;
    for ($i=0; $i < count($sizes); $i++) {
      $data = $sizes[$i];
      for ($j=0; $j < count($data); $j++) {
        if (isset($data[$j]['id'])) {
          if (isset($data[$j]['color_id'])) {
            if (isset($data[$j]['size_id']) && isset($data[$j]['stock'])) {
              if ($data[$j]['size_id'] > 0 && $data[$j]['color_id'] > 0) {
                DB::table('color_sizes')
                ->where('id', $data[$j]['id'])
                ->update([
                  'size_id' => $data[$j]['size_id'],
                  'color_id' => $data[$j]['color_id'],
                  'stock' => $data[$j]['stock']
                ]);
              }
            }
          } else {
            if ($data[$j]['size_id'] > 0) {
              DB::table('color_sizes')
              ->where('id', $data[$j]['id'])
              ->delete();
            }
          }
        } else {
          if (isset($data[$j]['size_id']) && isset($data[$j]['color_id']) && isset($data[$j]['stock'])) {
            if ($data[$j]['size_id'] > 0 && $data[$j]['color_id'] > 0) {
              DB::table('color_sizes')
                  ->insert([
                    'size_id' => $data[$j]['size_id'],
                    'color_id' => $data[$j]['color_id'],
                    'stock' => $data[$j]['stock']
                  ]);
            }
          }
        }
      }
    }
    return back()->withInput();
  }

  public function refreshRandom(Request $request)
  {
    Product::all()->each(function($p) {
      $p->qty = rand(1, 1000);
      $p->save();
    });
    return response()->json(['message' => 'OK']);
  }

  public function search(Request $request)
  {
    $likes = explode('%20',$request->like);
    $likes = explode(' ',$likes[0]);
    foreach ($likes as $like) {
      $new_like = "(name LIKE '%".$like."%') + (code LIKE '%".$like."%')";
      if(isset($db_raw)){
        $db_raw = $db_raw." + ".$new_like;
      }else{
        $db_raw = $new_like;
      }
    }
    $products = Product::selectRaw("products.*,(".$db_raw.") as hits")
                      ->havingRaw('('.$db_raw.') > 0' )
                      ->groupby('id', 'code', 'slug', 'name', 'name_en', 'description', 'description_en', 'qty', 'status', 'color_sizes_status', 'image', 'price', 'promo', 'created_at', 'updated_at')
                      ->orderby(DB::raw('hits'), 'DESC')
                      ->get();

    return view('admin.products.index')->with([
      'newProducts' => $products
    ]);
  }
}
