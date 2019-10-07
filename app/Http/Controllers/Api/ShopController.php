<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Characteristic;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /*
         * Query params
         * attrs: 1,2,3
         * cats: 1,2,3
         * order: (name|price)
         * dir: (asc|desc)
         * per_page: 20
         */

        // Make the initial query with the data that we want
        $cols = ['id', 'code', 'slug', 'name', 'image', 'price', 'promo'];
        // $products = Product::select($cols);
        $products = Product::select($cols)->where('status', '=', 1);

        // Get all attribute ids as array of integers
        $attr_ids = $this->getIds($request->attrs);

        // Get all characteristics based on our attributes
        $chars = DB::table('attributes')
          ->whereIn('id', $attr_ids)
          ->select('id', 'characteristic_id')
          ->get();

        // Set an array of characteristics grouped by characteristic_id
        $chars = collect($chars)->groupBy('characteristic_id');

        // Query by attributes of characteristics
        foreach ($chars as $attrs) {
          try {
            //code...
              $products->whereHas('attributes', function ($a)  use ($attrs){
                $a->whereIn('attributes.id', $attrs->pluck('id'));
              });
          } catch (\Throwable $th) {
            throw $th;
          }
        }

        // Query by categories
        $cats = $this->getIds($request->cats);
        if (isset($cats) && $cats->isNotEmpty()) {
          $products->whereHas('categories', function ($c) use ($cats) {
            $c->whereIn('categories.id', $cats);
          });
        }

        // Order by
        $availables = collect(['name', 'price', 'qty']);
        $order_by = $availables->contains($request->order)
          ? $request->order : $availables->first();

        // Order direction
        $dir = collect(['asc', 'desc'])->contains($request->dir)
          ? $request->dir : 'asc';

        // Per page logic
        $per_page = (int) $request->per_page;
        $per_page_cond = $per_page <= 50 && $per_page > 0;
        $per_page = $per_page_cond ? $per_page : 15;

        // Sort it and get using paginate with the current params
        $products = $products
          ->orderBy($order_by, $dir)
          ->paginate($per_page)
          ->appends($request->input());

        return response()->json($products);
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
        //
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

    public function data(Request $request)
    {
        $cats = Category::all();
        $chars = Characteristic::with('attributes')->get();
        return response()->json([
          'categories' => $cats,
          'characteristics' => $chars
        ]);
    }

    private function getIds($str='')
    {
        return collect(explode(',', trim($str)))
          ->filter(function ($id) { return trim($id); })
          ->map(function ($id) { return (int) $id; });
    }
}
