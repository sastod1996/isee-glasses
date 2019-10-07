<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Attribute;
use App\AttributeProduct;
use App\Client;
use App\ColorSize;
use App\Enterprise;
use App\Interesado;
use App\Order;
use App\Product;
use App\User;
use Excel;
use Mail;
use Validator;
use DateTime;

ini_set('max_execution_time', 180);

class ExcelController extends Controller
{
  public function orderfiles()
  {
    $arrayDirectories = [];
    $directory = '/products';
    $directories = Storage::directories('ordenados');
    foreach ($directories as $directory) {
      $foldername = explode('/', $directory);
      $foldername = array_pop($foldername);
      if (!Storage::exists($directory.'/'.$foldername.'.jpg')) {
        $files = Storage::files($directory);
        Storage::move($files[0], $directory.'/'.$foldername.'.jpg');
      }
      $directories2 = Storage::directories($directory);
      foreach ($directories2 as $directory2) {
        $foldername2 = explode('/', $directory2);
        $foldername2 = array_pop($foldername2);
        if ($foldername2 == 'images') {
          $directories3 = Storage::directories($directory2);
          foreach ($directories3 as $directory3) {
            $files2 = Storage::files($directory3);
            $count = 1;
            foreach ($files2 as $file2) {
              if (!Storage::exists($directory3.'/'.$foldername.'-'.$count.'.jpg')) {
                Storage::move($file2, $directory3.'/'.$foldername.'-'.$count.'.jpg');
              }
              $count = $count + 1;
            }
          }
        } else {
          $directories3 = Storage::directories($directory2);
          foreach ($directories3 as $directory3) {
            if (!Storage::exists($directory3.'/'.$foldername.'.png')) {
              $files2 = Storage::files($directory3);
              Storage::move($files2[0], $directory3.'/'.$foldername.'.png');
            }
          }
        }
      }
      Storage::deleteDirectory('/public/products/'.$foldername);
      Storage::move($directory.'/', '/public/products/'.$foldername.'/');
    }
    return back()->withInput();
  }

  public function export(Request $request, $type){
    $validator = $this->validateRequest($request);

    if ($validator->fails()) {
      $request->session()->flash('error', 'Debe ingresar un rango de fechas');
    } else {
      $start_date = new DateTime($request->start_date);
      $end_date = new DateTime($request->end_date);
      $diff = $start_date->diff($end_date);
      $months = ( $diff->y * 12 ) + $diff->m + $diff->d/31;

      if ($months > 2) {
        $request->session()->flash('error', 'El rango es mayor a dos meses');
      }else{
        $current_date = Carbon::now()->format('Ymd');

        // 1(ordenes en proceso) - 2(ordenes finalizadas)
        if ( $type == 2 ) {
          $states = [5,6]; //entregadas al cliente o anuladas
        }else {
          $condition = '!=';
          $state_id = 5;
          $states = [1,2,3,4];
        }

        $orders = Order::join('order_state', 'orders.id', '=', 'order_state.order_id')
        ->where('order_state.active', '=', 1)
        ->whereIn('order_state.state_id', $states)
        ->join('states', 'states.id', '=', 'order_state.state_id')
        ->join('order_product', 'orders.id', '=', 'order_product.order_id')
        ->groupBy('orders.id', 'orders.code', 'orders.date_order', 'orders.price', 'states.name', 'order_state.date')
        ->orderBy('orders.date_order', 'orders.id')
        ->select('orders.id', 'orders.code', DB::raw('count(order_product.order_id) as items'), 'orders.date_order', 'orders.price', 'states.name', 'order_state.date')
        ->where('orders.date_order','<=', $end_date)
        ->where('orders.date_order','>=', $start_date)
        ->get();

        // dd($orders);
        if ($orders->count() <= 0) {
          $request->session()->flash('error', 'No existen órdenes en el rango de fechas indicado');
        }else {
          Excel::create('ISEE'.$current_date, function($excel) use ($orders){

            $excel->setCreator('Administrador')
                  ->setCompany('I-SEE');
            $excel->setDescription('Gestion de ventas por pedido');

            //First sheet
            $excel->sheet('Resumen de Ordenes', function($sheet) use($orders) {
              $sheet->setPageMargin(0.25);

              $sheet->cells('A1:G1', function($cells) {
                $cells->setBackground('#B6AFAD');
              });

              $sheet->row(1, array('N° Pedido', 'Cod. Orden', '# Items', 'Fecha Orden', 'Monto', 'Estado', 'Fecha Estado')); // 'Emisión OrdTra', 'Fecha OrdTra', 'Envío Laboratorio', 'Fecha EnvLab', 'Recepcion Lab', 'Fecha RecLab', 'Envio Cliente', 'Fecha EnvCli', 'Entrega Cliente', 'Fecha EntCli'));
              $sheet->fromArray($orders, null, 'A2', true, false);
            });

            foreach ($orders as $order) {

              $excel->sheet('Orden'.$order->code, function($sheet) use($order){
                $ord = Order::find($order->id);

                $sheet->rows(array(
                  array('CÓDIGO ORDEN', $ord->code),
                  array('CLIENTE', $ord->client->user->first_name.' '.$ord->client->user->last_name),
                  array('PAÍS', $ord->country),
                  array('CIUDAD', $ord->city),
                  array('DISTRITO', $ord->district),
                  array('REFERENCIA', $ord->reference),
                  array('DIRECCIÓN', $ord->address),
                  array('SUBTOTAL', $ord->subtotal),
                  array('DESCUENTO', $ord->discount,'', 'CUPÓN', isset($ord->coupon_id) ? $ord->coupon->code : '-'),
                  array('TOTAL', $ord->price)
                ));

                $ord->products = Product::distinct()
                                    ->join('order_product', 'products.id', '=', 'order_product.product_id')
                                    ->join('attribute_product', 'attribute_product.product_id', '=', 'order_product.product_id')
                                    ->join('attributes as marca', 'marca.id', '=', 'attribute_product.attribute_id')
                                    ->join('characteristics', 'characteristics.id', '=', 'marca.characteristic_id')
                                    ->where('characteristics.slug', '=', 'marca')
                                    ->join('attributes as color', 'color.id', '=', 'order_product.color_id')
                                    ->join('attributes as size', 'size.id', '=', 'order_product.size_id')
                                    ->join('attribute_product as attr_size_prod', 'attr_size_prod.id', '=', 'order_product.size_attr')
                                    ->join('types as types', 'types.id', '=', 'order_product.type_id')
                                    ->join('packs', 'packs.id', '=', 'order_product.pack_id')
                                    ->leftjoin('options', 'options.id', '=', 'order_product.opt_id')
                                    ->leftjoin('aditcolors', 'aditcolors.id', '=', 'order_product.optcolor_id')
                                    // ->leftjoin('prescriptions as pres', 'pres.id', '=', 'order_product.prescription_id')
                                    ->where('order_product.order_id', '=', $ord->id)
                                    ->select('products.id', 'products.code', 'order_product.prod_price as prod_price',
                                             'types.name as tipo', 'packs.name as paquete', 'order_product.pack_price as pack_price','options.name as adicional', 'aditcolors.name as color_adicional', 'order_product.opt_price as opt_price',
                                             'marca.name as marca',
                                             'color.name as color', 'order_product.code_color as code_color', 'size.name as size', 'attr_size_prod.bridge as bridge', 'attr_size_prod.width as width','attr_size_prod.height as height','attr_size_prod.large as large',
                                             'order_product.subtotalprice as subtotal','order_product.discount as descuento', 'order_product.totalprice as total',
                                             DB::raw('null'),
                                             'order_product.pres_esfod', 'order_product.pres_esfoi', 'order_product.pres_cilod', 'order_product.pres_ciloi', 'order_product.pres_axiod', 'order_product.pres_axioi', 'order_product.pres_addod', 'order_product.pres_addoi', 'order_product.pres_esfdip', 'order_product.pres_dip')
                                    ->orderBy('products.id')
                                    ->get();

                // dd($ord->products);

                $sheet->setAutoSize(true);
                $sheet->setBorder('A1:B10', 'thin');
                $sheet->cells('A1:A10', function($cells) {
                  $cells->setBackground('#B6AFAD');
                });
                $sheet->setBorder('D9:E9', 'thin');
                $sheet->cells('D9', function($cells) {
                  $cells->setBackground('#B6AFAD');
                });
                $sheet->setBorder('A12:T12', 'thin');
                $sheet->cells('A12:T12', function($cells) {
                  $cells->setAlignment('center');
                  $cells->setBackground('#B6AFAD');
                });
                $sheet->setBorder('V11:AD12', 'thin');
                $sheet->cells('V11:AD12', function($cells) {
                  $cells->setAlignment('center');
                  $cells->setBackground('#B6AFAD');
                });
                $sheet->mergeCells('V11:AD11');
                $sheet->cell('V11', function($cell) {
                  $cell->setValue('PRESCRIPCION');
                  $cell->setAlignment('center');
                });

                $sheet->row(12, array('ID', 'CODIGO', 'PRECIO X PROD.', 'TIPO', 'PAQUETE', 'PRECIO X PAQ.', 'ADICIONAL', 'COLOR ADICIONAL', 'PRECIO X ADIC.',
                                      'MARCA', 'COLOR', 'CÓDIGO COLOR', 'TAMAÑO', 'PUENTE', 'ANCHO', 'ALTO', 'LARGO', 'SUBTOTAL', 'DESCUENTO', 'TOTAL','',
                                      'ESFOD', 'ESFOI', 'CILOD', 'CILOI', 'AXIOD', 'AXIOI', 'ADDOD', 'ADDOI', 'ESFDIP', 'DIP'
                                      ));
                $sheet->fromModel($ord->products, null, 'A13', true, false);
              });
            }
          })->export('xls');
        }

      }
    }
    return back();
  }

  public function exportClients(Request $request)
  {
    $validator = $this->validateRequest($request);

    if ($validator->fails()) {
      $request->session()->flash('error', 'Debe ingresar un rango de fechas');
    } else {
      $start_date = new DateTime($request->start_date);
      $end_date = new DateTime($request->end_date);
      $diff = $start_date->diff($end_date);
      $months = ( $diff->y * 12 ) + $diff->m + $diff->d/31;

      if ($months > 2) {
        $request->session()->flash('error', 'El rango es mayor a dos meses');
      }else{
        $clients = Client::join('users', 'users.id', 'clients.user_id')
                         ->where('clients.created_at', '>=', $start_date)
                         ->where('clients.created_at', '<=', $end_date)
                         ->select('users.last_name', 'users.first_name', 'clients.dni', 'users.email', 'users.telephone',
                                  'clients.country', 'clients.city', 'clients.code', 'clients.district', 'clients.address', 'clients.reference',
                                  'clients.created_at')
                         ->orderBy('users.last_name')
                         ->get();

        if ($clients->count() <= 0) {
          $request->session()->flash('error', 'No existen clientes en el rango de fechas indicado');
        }else {
          $current_date = Carbon::now()->format('Ymd');

          Excel::create('ISEE-Clientes-'.$current_date, function($excel) use ($clients, $start_date, $end_date){
            $excel->setCreator('Administrador')
                  ->setCompany('I-SEE');
            $excel->setDescription('Registro de clientes');

            //First sheet
            $excel->sheet('ISEE-Clientes', function($sheet) use($clients, $start_date, $end_date) {
              $sheet->setPageMargin(0.25);
              $title = 'ISEE - Clientes registrados durante el periodo '.$start_date->format('d/m/Y').' al '.$end_date->format('d/m/Y');

              $sheet->mergeCells('A2:L2');
              $sheet->cell('A2', function($cell) use($title) {
                $cell->setValue( $title );
                $cell->setAlignment('center');
              });

              $sheet->setAutoSize(true);
              $sheet->setBorder('A4:L4', 'thin');
              $sheet->cells('A4:L4', function($cells) {
                $cells->setBackground('#B6AFAD');
              });

              $sheet->row(4, array('Apellidos', 'Nombres', 'DNI', 'Email', 'Teléfono',
                                   'País', 'Ciudad', 'Cod. Postal', 'Distrito', 'Dirección', 'Referencia', 'Fecha de registro')); // 'Emisión OrdTra', 'Fecha OrdTra', 'Envío Laboratorio', 'Fecha EnvLab', 'Recepcion Lab', 'Fecha RecLab', 'Envio Cliente', 'Fecha EnvCli', 'Entrega Cliente', 'Fecha EntCli'));

              $sheet->fromArray($clients, null, 'A5', true, false);
            });


          })->export('xls');

        }

      }
    }
    return back();
  }

  public function exportInteresados(Request $request)
  {
    $validator = $this->validateRequest($request);

    if ($validator->fails()) {
      $request->session()->flash('error', 'Debe ingresar un rango de fechas');
    } else {
      $start_date = new DateTime($request->start_date);
      $end_date = new DateTime($request->end_date);
      $diff = $start_date->diff($end_date);
      $months = ( $diff->y * 12 ) + $diff->m + $diff->d/31;

      if ($months > 2) {
        $request->session()->flash('error', 'El rango es mayor a dos meses');
      }else{
        $interesados = Interesado::where('created_at', '>=', $start_date)
                                 ->where('created_at', '<=', $end_date)
                                 ->orderBy('name')
                                 ->select('name', 'email', 'telephone')
                                 ->get();

        if ($interesados->count() <= 0) {
          $request->session()->flash('error', 'No existen clientes en el rango de fechas indicado');
        }else {
          $current_date = Carbon::now()->format('Ymd');

          Excel::create('ISEE-Interesados-'.$current_date, function($excel) use ($interesados, $start_date, $end_date){
            $excel->setCreator('Administrador')
                  ->setCompany('I-SEE');
            $excel->setDescription('Registro de interesados');

            //First sheet
            $excel->sheet('ISEE-Clientes', function($sheet) use($interesados, $start_date, $end_date) {
              $sheet->setPageMargin(0.25);
              $title = 'ISEE - Interesados registrados durante el periodo '.$start_date->format('d/m/Y').' al '.$end_date->format('d/m/Y');

              $sheet->mergeCells('A2:C2');
              $sheet->cell('A2', function($cell) use($title) {
                $cell->setValue( $title );
                $cell->setAlignment('center');
              });

              $sheet->setAutoSize(true);
              $sheet->setBorder('A4:C4', 'thin');
              $sheet->cells('A4:C4', function($cells) {
                $cells->setBackground('#B6AFAD');
              });

              $sheet->row(4, array('Nombres', 'Email', 'Teléfono'));

              $sheet->fromArray($interesados, null, 'A5', true, false);
            });


          })->export('xls');

        }

      }
    }
    return back();
  }

    // CSV products keys details
  private $ks_products = [
    'product' => [
      'code' => '1',
      // 'laboratory_code' => '2',
      'name' => '3',
      'name_en' => '4',
      'price' => '5',
      'promo' => '6',
      'description' => '32'
    ],
    'category_names' => '7', // Concatenated with commas
    'char_names' => [ // by slug
      'color' => '8', // Concatenated with ,
      'marca' => '9',
      'uso' => '10',
      'montura' => '11',
      'forma' => '12',
      'genero' => '13',
      'tipo' => '14',
      'material' => '15',
    ],
    // 'sizes' => [ // $size_id => [bridge, width, height, large]
    //   '16' /* s  */ => ['16', '17', '18', '19'],
    //   '17' /* m  */ => ['20', '21', '22', '23'],
    //   '18' /* l  */ => ['24', '25', '26', '27'],
    //   '19' /* xl */ => ['28', '29', '30', '31']
    // ],
    'sizes' => [ // $size_id => [width, bridge, large, height
      '16' /* s  */ => ['16', '17', '18', '19'],
      '17' /* m  */ => ['20', '21', '22', '23'],
      '18' /* l  */ => ['24', '25', '26', '27'],
      '19' /* xl */ => ['28', '29', '30', '31']
    ]
  ];

  private $titles_products = [
    'indice', 'codigo_producto', 'codigo_de_laboratorio', 'nombre',
    'nombreingles', 'precio', 'promo', 'categoria',
    'color', 'marca', 'uso', 'montura',
    'forma', 'genero', 'tipo', 'material',
    's_puente', 's_ancho', 's_alto', 's_largo',
    'm_puente', 'm_ancho', 'm_alto', 'm_largo',
    'l_puente', 'l_ancho', 'l_alto', 'l_largo',
    'xl_puente', 'xl_ancho', 'xl_alto', 'xl_largo',
    'descripcion'
  ];

  public function importProducts(Request $request)
  {
    if (!isset($request->excel)) {
      $request->session()->flash('danger', 'Archivo requerido');
      return redirect()->route('products.index');
    }

    // Verify file
    $path = '';
    try {
      $path = $request->excel->getClientOriginalName();
    } catch (Exception $e) {
      $request->session()->flash('danger', 'Archivo inválido');
      return redirect()->route('products.index');
    }

    if (!preg_match('/(.xlsx|.xls|.csv)$/', $path)) {
      $request->session()->flash('danger', 'Archivo inválido');
      return redirect()->route('products.index');
    }

    // Save file
    Storage::disk('excels')->put($path, file_get_contents($request->excel));

    // Read file
    Excel::load('storage/app/public/excels/'.$path, function($reader) use ($request) {
      $errors = [];
      $warnings = [];

      // Prepare source
      $rows = array_map('array_values', $reader->toArray());
      $ks = (object) $this->ks_products;

      // Differents columns
      $title = array_map('array_keys', $reader->toArray())[0];
      $diff = array_diff($this->titles_products, $title);

      if ( count($diff) > 0 ) {
        $request->session()->flash('danger', 'Archivo inválido');
        return redirect()->route('products.index');
      }

      // dd($rows);
      // One by one
      foreach ($rows as $i => $row) {

        // Build product
        // $product = new Product;
        $product = Product::firstOrNew(['code' => $row['1']]);
        foreach ($ks->product as $key => $col) {
          $product->$key = $row[$col];
        }
        // Additional
        $product->slug = str_slug($product->code);
        $product->status = 0;
        $product->qty = rand(1, 1000);

        // Put image and url
        $product->image = '/storage/products/'.$product->slug.'/'.$product->slug.'.jpg';

        // Create directory
        $fileExists = Storage::exists('/public/products/'.$product->slug.'/'.$product->slug.'.jpg');
        if (!$fileExists) {
          Storage::disk('products')->makeDirectory($product->slug);
          Storage::copy('placeimg/copy.png', '/public/products/'.$product->slug.'/'.$product->slug.'.jpg');
        }

        // Save product
        try {
          $product->save();
        } catch (\Illuminate\Database\QueryException $exception) {
          array_push($errors, $product->code);
          continue;
        }

        // Build categories
        $cat_names = array_map('trim', explode(',', $row[$ks->category_names]));
        $categories = DB::table('categories')->whereIn('name', $cat_names)->pluck('id');

        // Sync categories
        $product->categories()->sync($categories);

        // Build and insert attribute products
        DB::table('attribute_product')->where('product_id', $product->id)->delete();
        foreach ($ks->char_names as $char => $col) {
          $attr_ids = [];
          if ($char === 'color') {
            $cnames = array_map('trim', explode(',', $row[$col]));
            $attr_ids = DB::table('attributes')->whereIn('name', $cnames)->pluck('id');

            // Create directory for colors
            if (!$fileExists) {
              foreach ($attr_ids as $attr_id) {
                $attr = Attribute::find($attr_id);
                for ($i=0; $i < 3; $i++) {
                  $j = $i + 1;
                  Storage::disk('products')->makeDirectory($product->slug.'/images/'.$attr->slug);
                  Storage::copy('placeimg/copy.png', '/public/products/'.$product->slug.'/images/'.$attr->slug.'/'.$product->slug.'-'.$j.'.jpg');
                }
                Storage::disk('products')->makeDirectory($product->slug.'/cameras/'.$attr->slug);
                Storage::copy('placeimg/copy.png', '/public/products/'.$product->slug.'/cameras/'.$attr->slug.'/'.$product->slug.'.png');
              }
            }
          } else {
            $attr_id = DB::table('attributes')->where('name', $row[$col])->value('id');
            array_push($attr_ids, $attr_id);
          }
          foreach ($attr_ids as $attr_id) {
            $attr_prod = ['product_id' => $product->id, 'attribute_id' => $attr_id];
            if (isset($attr_id)) {
              $attr_prod_id = DB::table('attribute_product')->insertGetId($attr_prod);
              $attr = Attribute::find($attr_id);
              if ($attr->characteristic->slug == 'color') {
                for ($i=0; $i < 3; $i++) {
                  $j = $i + 1;
                  $url = '/storage/products/'.$product->slug.'/images/'.$attr->slug.'/'.$product->slug.'-'.$j.'.jpg';
                  DB::table('images')->insert(['url' => $url, 'attribute_product_id' => $attr_prod_id]);
                }
                $url = '/storage/products/'.$product->slug.'/cameras/'.$attr->slug.'/'.$product->slug.'.png';
                DB::table('cameras')->insert(['url' => $url, 'attribute_product_id' => $attr_prod_id]);
                // Labcolor

              }
            }else {
              if (!isset($warnings[$product->code])) {
                $warnings[$product->code] = [];
              }
              array_push($warnings[$product->code], 'Algo dentro de '.$row[$col].' no existe.');
            }
          }
        }

        // Build and insert attribute products for sizes
        foreach ($ks->sizes as $size_id => $values) {
          $measures = $row[$values[0]] + $row[$values[1]] + $row[$values[2]] + $row[$values[3]];
          if ( $measures > 0) {
            $attr_prod = [
              'product_id' => $product->id,
              'attribute_id' => $size_id,
              'width' => $row[$values[0]],
              'bridge' => $row[$values[1]],
              'large' => $row[$values[2]],
              'height' => $row[$values[3]],
            ];
            DB::table('attribute_product')->insert($attr_prod);
          }
        }
      }

      if (count($warnings) > 0) {
        $request->session()->flash('warning', 'Alertas');
        $request->session()->flash('products_warnings', $warnings);
      }

      if (count($errors) > 0) {
        $request->session()->flash('danger', 'Error en los productos');
        $request->session()->flash('products', join(';', $errors));
      } else {
        $request->session()->flash('success', 'Archivo procesado correctamente');
      }
    });

    return redirect()->route('products.index');
  }

  // CSV keys details
  private $ks_stock = [
    'prod_code' => '1',
    'lab_code' => '2',
    'size' => '3',
    'color' => '4',
    'stock' => '5'
  ];
  private $titles_stock = [
    'indice',
    'codigo_producto',
    'tamano',
    'color',
    'stock'
  ];

  public function importStock(Request $request)
  {
    if (!isset($request->excel)) {
      $request->session()->flash('danger', 'Archivo requerido');
      return redirect()->route('products.index');
    }

    // Verify file
    $path = '';
    try {
      $path = $request->excel->getClientOriginalName();
    } catch (Exception $e) {
      $request->session()->flash('danger', 'Archivo inválido');
      return redirect()->route('products.index');
    }

    if (!preg_match('/(.xlsx|.xls|.csv)$/', $path)) {
      $request->session()->flash('danger', 'Archivo inválido');
      return redirect()->route('products.index');
    }

    // Save file
    Storage::disk('excels')->put($path, file_get_contents($request->excel));

    // Read file
    Excel::load('storage/app/public/excels/'.$path, function($reader) use ($request) {
      $errors = [];
      $warnings = [];

      // Prepare source
      $rows = array_map('array_values', $reader->toArray());

      // Differents columns
      $title = array_map('array_keys', $reader->toArray())[0];
      $diff = array_diff($this->titles_stock, $title);

      if ( count($diff) > 0 ) {
        $request->session()->flash('danger', 'Archivo inválido');
        return redirect()->route('products.index');
      }

      $ks = (object) $this->ks_stock;

      // dd($rows);
      // One by one
      foreach ($rows as $i => $row) {
        $prod_code = str_slug($row[$ks->prod_code]);
        $color = str_slug($row[$ks->color]);
        $size = str_slug($row[$ks->size]);

        $product = Product::where('slug', $prod_code)->first();
        if (isset($product)) {
          $lab_code = (string)$row[$ks->lab_code];
          $stock = $row[$ks->stock];

          $attr_col = Attribute::where('slug', $color)->first();
          $attr_siz = Attribute::where('slug', $size)->first();

          if (isset($attr_col) && isset($attr_siz)) {
            DB::table('attribute_product')
            ->where('product_id', $product->id)
            ->where('attribute_id', $attr_col->id)
            ->update(['lab_codecolor' => $lab_code]);

            $prodcol = AttributeProduct::where(['product_id' => $product->id, 'attribute_id' => $attr_col->id])->first();
            $prodsiz = AttributeProduct::where(['product_id' => $product->id, 'attribute_id' => $attr_siz->id])->first();
            if (isset($prodcol) && isset($prodsiz)) {
              $colorsize = ColorSize::where(['color_id' => $prodcol->id, 'size_id' => $prodsiz->id])->first();
              if (!isset($colorsize)) {
                DB::table('color_sizes')->insert(['color_id' => $prodcol->id, 'size_id' => $prodsiz->id, 'stock' => $stock]);
                $product->status = 1;
                $product->color_sizes_status = 1;
                try {
                  $product->save();
                } catch (\Illuminate\Database\QueryException $exception) {
                  array_push($errors, $product->code);
                  // continue;
                }
              }
            } else {
              array_push($errors, 'La relación entre el producto '.$prod_code.' y el color '.$attr_col->slug.' o el tamaño '.$attr_siz->slug.' no existe.');
            }
          } else {
            array_push($errors, 'El color y el tamaño de '.$prod_code.' no existen.');
          }
        } else {
          array_push($errors, 'No existe producto con código: '.$prod_code);
        }
      }

      if (count($warnings) > 0) {
        $request->session()->flash('warning', 'Alertas');
        $request->session()->flash('products_warnings', $warnings);
      }

      if (count($errors) > 0) {
        $request->session()->flash('danger', 'Error en los productos');
        $request->session()->flash('products', join(';', $errors));
      } else {
        $request->session()->flash('success', 'Archivo procesado correctamente');
      }
    });

    return redirect()->route('products.index');
  }

  // Importar values
  private $positions = [
    'enterprise' => '1',
    'user' => [
      'first_name' => '2',
      'last_name' => '3',
      'email' => '4',
      'telephone' => '5'
    ],
    'client' => [
      'country' => '6',
      'city' => '7',
      'code' => '8',
      'district' => '9',
      'address' => '10',
      'reference' => '11'
    ]
  ];

  public function importClients(Request $request)
  {
    if (!isset($request->excel)) {
      $request->session()->flash('danger', 'Archivo requerido');
      return redirect()->route('clients.index');
    }
    // Verify file
    $path = '';
    try {
      $path = $request->excel->getClientOriginalName();
    } catch (\Exception $e) {
      $request->session()->flash('danger', 'Archivo inválido');
      return redirect()->route('clients.index');
    }

    if (!preg_match('/(.xlsx|.xls|.csv)$/', $path)) {
      $request->session()->flash('danger', 'Archivo inválido');
      return redirect()->route('clients.index');
    }

    // Save file
    Storage::disk('excels')->put($path, file_get_contents($request->excel));

    // Read file
    try {
      Excel::load('storage/app/public/excels/'.$path, function($reader) use ($request) {
        $errors = [];
        $warnings = [];

        // Prepare source
        $rows = array_map('array_values', $reader->toArray());
        $ks = (object) $this->positions;

        // One by one
        foreach ($rows as $i => $row) {
          try {
            // Build Client
            $user = new User;
            foreach ($ks->user as $key => $col) {
              $user->$key = $row[$col];
            }
          } catch (\Exception $e) {
            $request->session()->flash('danger', 'Fallo en crear usuario');
            return redirect()->route('clients.index');
          }

          // Build a client password
          $user->password = bcrypt('IseePassword2018aliado');
          $user->role_id = 2;
          $user->rate_id = 1;

          // Save Client
          try {
            $user->save();
            $user->client()->create([
              'user_id' => $user->id,
              'ally' => true
            ]);
            foreach ($ks->client as $key => $col) {
              if (isset($row[$col])) {
                $user->client()->update([
                  $key => $row[$col]
                ]);
              }
            }
          } catch (\Illuminate\Database\QueryException $exception) {
            // dd($exception);
            array_push($warnings, $user);
            // $request->session()->flash('danger', 'Fallo en crear cliente '.$user->first_name.' '.$user->last_name);
            continue;
          }

          // Save Enterprise
          $enterprise_name = $row[$ks->enterprise];
          $enterprise = Enterprise::where('name', '=', $enterprise_name)->first();
          if (!isset($enterprise)) {
            $enterprise = Enterprise::create([
              'name' => $enterprise_name
            ]);
          }
          $user->client()->update([
            'enterprise_id' => $enterprise->id
          ]);

          // try {
          //   Mail::send('site.mail.welcome-ally', array(
          //     'first_name' => $user->first_name
          //   ), function($message) use ($user) {
          //     $message->from('service@isee-glasses.com', 'I-SEE Service');
          //     $message->to($user->email, $user->first_name);
          //     $message->subject('BIENVENIDO');
          //   });
          // } catch (Exception $e) {
          //   $request->session()->flash('danger', 'Fallo al enviar correo');
          //   continue;
          // }

        }

        if (count($warnings) > 0) {
          // dd($warnings);
          $request->session()->flash('warning', 'Alertas');
          $request->session()->flash('clients_warnings', $warnings);
        }

      });
      return redirect()->route('clients.index');
    } catch (\Exception $e) {
      $request->session()->flash('danger', 'Fallo en el try');
      return redirect()->route('clients.index');
    }
  }

  private function validateRequest(Request $request){
    $rules = [
    'start_date' => 'required',
    'end_date' => 'required'
    ];
    $messages = [
    'start_date.required' => 'Debe ingresar un rango de fechas'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
