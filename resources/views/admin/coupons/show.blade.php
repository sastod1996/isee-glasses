@extends('layouts.admin')

@section('content')

  @php
    $symbol = 'S/.';
    $value = 1;
  @endphp

  <div class="">
    <div class="">
      <div class="">
        <div class="">
          <div class="uk-h2">
            Órdenes del Cupón <strong>{{ $coupon->code }}</strong>
            <div class="uk-align-right">
                <a class="uk-button uk-button-default" href="{{ route('coupons.index') }}">REGRESAR</a>
            </div>
          </div>
        </div>
        {{-- <hr> --}}
        <div class="">
          @if ($coupon->orders->count()<=0)
            <p>No existen órdenes para este cupón</p>
          @else
            <div class="">
            <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
              <thead>
                <tr>
                  <th class="uk-width-small">Nro. Órden</th>
                  <th class="uk-table-shrink">Código rastreo</th>
                  <th class="uk-width-small">Fecha orden (mm/dd/yy)</th>
                  <th class="uk-width-small">Estado actual</th>
                  <th class="uk-width-small">Fecha estado (mm/dd/yy)</th>
                  <th>Subtotal</th>
                  <th>Cupón</th>
                  <th>Descuento total</th>
                  <th>Total</th>
                  {{-- @if (Auth::user()->is_administrator())
                  <th>Acciones</th>
                  @endif --}}
                </tr>
              </thead>
              <tbody>
                @foreach ($coupon->orders as $order)
                  <tr>
                    <th>{{ $order->nro }}</th>
                    <td>{{ $order->code }}</td>
                    <td>{{ date('m/d/Y', strtotime($order->date_order)) }}</td>
                    <td>{{ $order->getCurrentState()->name }}</td>
                    <td>{{ date('m/d/Y', strtotime($order->getCurrentState()->pivot->date)) }}</td>
                    <td>{{ $symbol }} {{ convertRate($order->subtotal, $value) }}</td>
                    <td>{{isset($order->coupon_id) ? $order->coupon->code : '-'}}</td>
                    <td>{{isset($order->coupon_id) ? $symbol.' '.convertRate($order->discount, $value) : '-'}}</td>
                    <td>{{ $symbol }} {{ convertRate($order->price, $value) }}</td>
                    {{-- @if (Auth::user()->is_administrator())
                      <td class="fit">
                        <a class="uk-button uk-button-primary uk-light"
                        href="{{ route('orders.show', ['id' => $order->id]) }}">
                        Ver Orden
                        </a>
                      </td>
                    @endif --}}
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

@endsection
