@extends('site.partials.navbar')

@section('navbar')
  @php
    $symbol = Auth::user()->rate->symbol;
    $value = Auth::user()->rate->value;
    $lang = App::getLocale();
  @endphp
  <div id="my-orders" class="uk-section uk-section-small">
    <div class="uk-container uk-container-small">
      @if ($orders->count()>0)
        <div class="uk-h2 uk-text-center isee-bold isee-spacing-small">
          @lang('orders.ordenes')
        </div>
        <div class="">
          <table class="uk-table uk-table-small uk-table-responsive uk-table-justify uk-table-hover uk-table-divider">
            <thead>
              <tr>
                <th class="uk-table-shrink uk-text-center"># </th>
                <th class="uk-text-center">@lang('orders.nro-order')</th>
                <th class="uk-text-center">@lang('orders.fecha')</th>
                <th class="uk-text-center">@lang('orders.estado')</th>
                <th class="uk-text-center">SUBTOTAL</th>
                <th class="uk-text-center">DESCUENTO</th>
                <th class="uk-text-center">@lang('orders.total')</th>
                <th class="uk-text-center"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orders as $order)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $order->nro }}</td>
                  <td>{{ $order->date_order }}</td>
                  <td>{{ $order->getCurrentState()->name }}</td>
                  <td>{{ $symbol }} {{ convertRate($order->subtotal, $value) }}</td>
                  <td>{{ $symbol }} {{ convertRate($order->discount, $value) }}</td>
                  <td>{{ $symbol }} {{ convertRate($order->price, $value) }}</td>
                  <td>
                    <button class="uk-button uk-button-default" type="button" uk-toggle="target: #modal-example-{{ $order->id }}">@lang('orders.detalles')</button>

                    <div id="modal-example-{{ $order->id }}" class="uk-modal-container" uk-modal>
                      <div class="uk-modal-dialog uk-modal-body">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <h2 class="uk-modal-title">@lang('orders.order-details')</h2>
                        <div class="uk-overflow-auto">
                          <table class="uk-table uk-table-striped" uk-table>
                            <thead>
                              <tr>
                                <th class="uk-text-center">@lang('orders.producto')</th>
                                <th class="uk-text-center uk-table-shrink">@lang('orders.caracteristicas')</th>
                                <th class="uk-text-center">@lang('orders.prescripcion')</th>
                                <th class="uk-text-center uk-width-small">@lang('orders.pack')</th>
                                <th class="uk-text-center uk-table-shrink">@lang('orders.adicionales')</th>
                                {{-- <th class="uk-text-center">@lang('orders.garantia')</th> --}}
                                <th class="uk-text-center uk-width-small">Subtotal</th>
                                <th class="uk-text-center uk-width-small">Descuento</th>
                                <th class="uk-text-center uk-width-small">Total</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($order->products as $item)
                                @php
                                  $type = App\Type::find($item->pivot->type_id);
                                  $pack = App\Pack::find($item->pivot->pack_id);
                                  $color = App\Attribute::find($item->pivot->color_id);
                                  $size = App\Attribute::find($item->pivot->size_id);
                                  $pres = App\Prescription::find($item->pivot->prescription_id);
                                @endphp
                                <tr>
                                  <td class="uk-text-center">
                                    <img class="uk-preserve-width" src="{{ $item->pivot->image }}" alt="{{ $item->slug }}" width="150px" height="150px">
                                    <ul class="uk-list uk-text-bold">
                                      <li>{{ $item->name }}</li>
                                      <li>(Cod. {{ $item->code }})</li>
                                      <li>{{ $symbol }} {{ convertRate($item->pivot->prod_price, $value) }}</li>
                                    </ul>
                                  </td>
                                  <td>
                                    <ul class="uk-list">
                                      @if ($lang == 'es')
                                        <li class="uk-text-capitalize">Color: {{ $color->name }} ({{ $item->pivot->code_color }})</li>
                                        <li class="uk-text-capitalize">Tamaño: {{ $size->name }}</li>
                                      @else
                                        <li class="uk-text-capitalize">Color: {{ $color->name_en }}</li>
                                        <li class="uk-text-capitalize">Tamaño: {{ $size->name_en }}</li>
                                      @endif
                                    </ul>
                                  </td>
                                  <td>{{ isset($pres) ? substr($pres->name, 0, 12) == 'isee-archivo' ? substr($pres->name,13) : $pres->name : '-' }}</td>
                                  {{-- <td>{{ $item->pivot->prescription_id }}</td> --}}
                                  @if ($lang == 'es')
                                    <td class="">
                                      <ul class="uk-list">
                                        <li class="uk-text-capitalize">Tipo: {{ $type->name }}</li>
                                        <li class="uk-text-capitalize">Paquete: {{ $pack->name }}</li>
                                        {{-- <li class="uk-text-right uk-text-bold">+ {{ $symbol }} {{ convertRate($item->pivot->pack_price, $value) }}</li> --}}
                                      </ul>
                                    </td>
                                    <td class="uk-text-capitalize">
                                      {{-- {{ dd($item) }} --}}
                                      @if (isset($item->pivot->opt_id))
                                        @php
                                        $option = App\Option::find($item->pivot->opt_id);
                                        $aditcolor = App\Aditcolor::find($item->pivot->optcolor_id);
                                        @endphp
                                          <ul class="uk-list">
                                            <li class="uk-text-capitalize">{{ $option->name }} {{ isset($aditcolor) ? '('.$aditcolor->name.')' : '' }}</li>
                                            <li class="uk-text-capitalize"> </li>
                                            {{-- <li class="uk-text-right uk-text-bold">+ {{ $symbol }} {{ convertRate($item->pivot->opt_price, $value) }}</li> --}}
                                          </ul>
                                      @endif
                                    </td>
                                  @else
                                    <td class="">
                                      <ul class="uk-list">
                                        <li class="uk-text-capitalize">Tipo: {{ $type->name_en }}</li>
                                        <li class="uk-text-capitalize">Paquete: {{ $pack->name_en }}</li>
                                        {{-- <li class="uk-text-right uk-text-bold">+ {{ $symbol }} {{ convertRate($item->pivot->pack_price, $value) }}</li> --}}
                                      </ul>
                                    </td>
                                    <td class="uk-text-capitalize">
                                      @if (isset($item->pivot->opt_id))
                                        @php
                                        $option = App\Option::find($item->pivot->opt_id);
                                        // $aditcolor = App\Aditcolor::find($item->pivot->optcolor_id);
                                        @endphp
                                          <ul class="uk-list">
                                            <li class="uk-text-capitalize">{{ $option->name }}</li>
                                            <li class="uk-text-capitalize"> bu {{ $item->pivot->optcolor_id }} </li>
                                            <li class="uk-text-right uk-text-bold">+ {{ $symbol }} {{ convertRate($item->pivot->opt_price, $value) }}</li>
                                          </ul>
                                      @endif
                                    </td>
                                  @endif
                                  <td>{{ $symbol }} {{ convertRate($item->pivot->subtotalprice, $value) }}</td>
                                  <td>
                                    @if (isset($item->pivot->warranty_id))
                                      @php
                                        $warranty = App\Warranty::find($item->pivot->warranty_id);
                                      @endphp
                                      @if ($lang == 'es')
                                        <ul class="uk-list">
                                          <li class="uk-text-capitalize">{{ $warranty->name }}</li>
                                          <li class="uk-text-capitalize"> </li>
                                          <li class="uk-text-right uk-text-bold">+ {{ $symbol }} {{ convertRate($item->pivot->warranty_price, $value) }}</li>
                                        </ul>
                                      @else
                                        <ul class="uk-list">
                                          <li class="uk-text-capitalize">{{ $warranty->name_en }}</li>
                                          <li class="uk-text-capitalize"> </li>
                                          <li class="uk-text-right uk-text-bold">+ {{ $symbol }} {{ convertRate($item->pivot->warranty_price, $value) }}</li>
                                        </ul>
                                      @endif
                                    @endif
                                    <ul class="uk-list">
                                      <li class="uk-text-capitalize">{{ $symbol }} {{ convertRate($item->pivot->discount, $value) }}</li>
                                      <li class="uk-text-capitalize"> </li>
                                    </ul>
                                  </td>
                                  <td>{{ $symbol }} {{ convertRate($item->pivot->totalprice, $value) }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      @else
        <div class="uk-h1 uk-text-center isee-bold isee-spacing-small">
          No ha realizado ninguna compra.
        </div>
        <div class="uk-h4 uk-text-center isee-bold">
          IR A <a class="uk-link-reset" href="/shop">COMPRAR</a>
        </div>
      @endif
    </div>
  </div>

@endsection
