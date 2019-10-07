<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Coupon;
use App\Product;
use App\Order;
use \Cart as Cart;
use Carbon\Carbon;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function discount(Request $request)
    {
      // return response()->json([
      //   'data' => $request->preorder['items']
      // ]);
      $now = Carbon::now()->format('Y-m-d');
      $discounted = false;

      $coupon = Coupon::where('code', '=', $request->code)
                      ->where('status', '=', 1)
                      ->where('start_date', '<=', $now)
                      ->where('end_date', '>=', $now)
                      ->with('attributes')
                      ->first();

      if (isset($coupon)) {

        if ($coupon->code == 'ISEEGLASSES50') {
          $last_order = Order::where('coupon_id', '=', $coupon->id)->where('client_id', '=', $request->client_id)->first();
          if ($last_order) {
            return response()->json([
              'success' => false,
              'message' => 'Este cupón ya fue usado'
            ]);
          } else {
            $preorder = new Order();
            $items =  collect();
            $discount_total = 0;
            $comission_total = 0;

            foreach ($request->preorder['items'] as $item) {
              $has_discount = false;
              $discount = 0;
              $comission = 0;
              
              // Start of old conditions
              
              // $product = Product::where('slug', '=', $item['slug'])->where('status', '=', 1)->with('attributes')->first();
              // $premium = false;
              // $promo = false;
              // $solar = false;
              // // Si el producto es premium
              // if (isset($item['attributes'])) {
              //   foreach ($item['attributes'] as $attr) {
              //     if ($attr['characteristic_id'] == 1 && $attr['premium']) {
              //       $premium = true;
              //     }
              //   }
              // }
              // // Si el producto es promociones
              // if (isset($item['categories'])) {
              //   foreach ($item['categories'] as $cat) {
              //     if ($cat['slug'] == 'promociones') {
              //       $promo = true;
              //     }
              //   }
              // }
              // // Si el producto es gafas de sol
              // if (isset($item['uso'])) {
              //   if ($item['uso']['slug'] == 'solares') {
              //     $solar = true;
              //   }
              // }
              // if (!$premium && !$promo && !$solar) {
              //   // Monofocal y bäsico
              //   if (isset($item['type'])) {
              //     if ($item['type']['slug'] == 'de-distancia' || $item['type']['slug'] == 'de-cerca') {
              //       if ($item['pack']['slug'] == 'basico') {
              //         $has_discount = true;
              //       }
              //     }
              //   }

              //   if ($has_discount) {
              //     $discount = $item['price']*($coupon->percent/100);
              //     if($discount > $coupon->limit) {
              //       $discount = $coupon->limit;
              //     }
              //     $item['discount'] = $discount;
              //     $item['totalprice'] = $item['totalprice'] - $discount;

              //     //Comisión por afiliado
              //     if ($coupon->affiliate_id != 0) {
              //       $comission = $item['price']*($coupon->percent_commission/100);
              //       if($comission > $coupon->max_commission){
              //         $comission = $coupon->max_commission;
              //       }
              //     }
              //     $item['comission'] = $comission;
              //     $discount_total += $discount;
              //     $comission_total += $comission;
              //     $discounted = true;
              //   }
              // }

              // End of old conditions

              // New condition
              if (isset($item['categories'])) {
                foreach ($item['categories'] as $cat) {
                  if ($cat['slug'] == '50-percent-off') {
                    $has_discount = true;
                  }
                }
              }

              if ($has_discount) {
                $discount = $item['price']*($coupon->percent/100);
                if($discount > $coupon->limit) {
                  $discount = $coupon->limit;
                }
                $item['discount'] = $discount;
                $item['totalprice'] = $item['totalprice'] - $discount;

                //Comisión por afiliado
                if ($coupon->affiliate_id != 0) {
                  $comission = $item['price']*($coupon->percent_commission/100);
                  if($comission > $coupon->max_commission){
                    $comission = $coupon->max_commission;
                  }
                }
                $item['comission'] = $comission;
                $discount_total += $discount;
                $comission_total += $comission;
                $discounted = true;
              }

              $items->push($item);
            }

            $preorder->items = $items;
            $preorder->coupon = $coupon;
            $preorder->coupon_id = $coupon->id;
            $preorder->subtotal = $request->preorder['subtotal'];
            $preorder->discount = $discount_total;
            $preorder->comission = $comission_total;
            $preorder->total = $request->preorder['total'] - $discount_total;

            if ($discounted) {
              return response()->json([
                'success' => true,
                'message' => 'Cupón válido',
                'discounted' => $discounted,
                'preorder' => $preorder,
                'data' => $preorder->items
              ]);
            }else {
              return response()->json([
                'success' => false,
                'message' => 'Cupón sin descuento'
              ]);
            }
          }
        } else {
          if ( $coupon->attributes->count() || $coupon->types->count() ) {
            $preorder = new Order();
            $items =  collect();
            $discount_total = 0;
            $comission_total = 0;

            foreach ($request->preorder['items'] as $item) {
              $has_discount = false;
              $discount = 0;
              $comission = 0;
              $product = Product::where('slug', '=', $item['slug'])
                                ->where('status', '=', 1)
                                ->with('attributes')
                                ->first();

              if ($coupon->attributes->count() > 0) {
                $attrs = $coupon->attributes->pluck('id');
                $valid_attrs = $product->attributes->whereIn('id', $attrs);

                if($valid_attrs->count() == $coupon->attributes->count()){
                  $has_discount = true;
                }
              }

              if ($coupon->types->count() > 0) {
                if($item['type']['id'] == $coupon->types[0]['id']){
                  $has_discount = true;
                }else {
                  $has_discount = false;
                }
              }

              if ($has_discount) {
                $discount = $item['totalprice']*($coupon->percent/100);
                if($discount > $coupon->limit){
                  $discount = $coupon->limit;
                }
                $item['discount'] = $discount;
                $item['totalprice'] = $item['totalprice'] - $discount;

                //Comisión por afiliado
                if ($coupon->affiliate_id != 0) {
                  $comission = $item['totalprice']*($coupon->percent_commission/100);
                  if($comission > $coupon->max_commission){
                    $comission = $coupon->max_commission;
                  }
                }
                $item['comission'] = $comission;
                $discount_total += $discount;
                $comission_total += $comission;
                $discounted = true;

              }
              $items->push($item);
            }

            $preorder->items = $items;
            $preorder->coupon = $coupon;
            $preorder->coupon_id = $coupon->id;
            $preorder->subtotal = $request->preorder['subtotal'];
            $preorder->discount = $discount_total;
            $preorder->comission = $comission_total;
            $preorder->total = $request->preorder['total'] - $discount_total;

            if ($discounted) {
              return response()->json([
                'success' => true,
                'message' => 'Cupón válido',
                'discounted' => $discounted,
                'preorder' => $preorder
              ]);
            } else {
              return response()->json([
                'success' => false,
                'message' => 'Cupón sin descuento'
              ]);
            }
          } else {
            return response()->json([
              'success' => false,
              'message' => 'Cupón inválido'
            ]);
          }

        }
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Cupón no disponible'
        ]);
      }
    }

    /**
     * Validar que el cliente solo use un cupon
     */
    private function couponUsed($client_id, $coupon_id){
      $orders = Order::where('client_id', '=', $client_id)
                     ->where('coupon_id', '=', $coupon_id)
                     ->get();
      return $orders->count() == 0 ? false : true;

    }
}
