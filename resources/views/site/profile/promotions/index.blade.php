@extends('site.partials.navbar')

@section('navbar')
  @php
    $symbol = Auth::user()->rate->symbol;
    $value = Auth::user()->rate->value;
    $lang = App::getLocale();
  @endphp
  <div id="coupons" class="uk-section uk-section-small">
    <div class="uk-container uk-container-small">
      @if ($coupons->count()>0)
        <div class="uk-h2 uk-text-center isee-bold isee-spacing-small">
          @lang('coupons.coupons')
        </div>
        <div class="">
        </div>
        <div class="">
          <table class="uk-table uk-table-small uk-table-responsive uk-table-justify uk-table-hover uk-table-divider">
            <thead>
              <tr>
                <th class="uk-table-shrink uk-text-center"># </th>
                <th class="uk-table-shrink uk-text-center">@lang('coupons.code')</th>
                <th class="uk-width-medium uk-text-center">@lang('coupons.characteristics')</th>
                <th class="uk-text-center">@lang('coupons.status')</th>
                <th class="uk-text-center">@lang('coupons.start-date')</th>
                <th class="uk-text-center">@lang('coupons.end-date')</th>
                <th class="uk-text-center">@lang('coupons.count')</th>
                <th class="uk-text-center">@lang('coupons.commission')</th>
                {{-- <th class="uk-text-center"></th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($coupons as $coupon)
                <tr>
                  <td >{{ $loop->index+1 }}</td>
                  <td>{{ $coupon->code }}</td>
                  <td>
                    <ul class="uk-list">
                      @foreach ($coupon->attributes as $attribute)
                        <li><b>Atributo: </b> {{ $attribute }}</li>
                      @endforeach
                      @foreach ($coupon->types as $type)
                        <li><b>Tipo: </b> {{ $type }}</li>
                      @endforeach
                    </ul>
                  </td>
                  <td>{{ $coupon->status == 1 ? 'Activo' : 'Inactivo' }}</td>
                  <td>{{ $coupon->start_date }}</td>
                  <td>{{ $coupon->end_date }}</td>
                  <td>{{ $coupon->count }}</td>
                  <td>{{ $symbol }} {{ convertRate($coupon->comission, $value) }}</td>
                  {{-- <td>
                    <button class="uk-button uk-button-default" type="button" uk-toggle="target: #modal-example-{{$coupon->id}}"
                      @if ($coupon->count == 0)
                        disabled
                      @endif
                      >@lang('coupons.detalles')</button>

                    <div id="modal-example-{{$coupon->id}}" class="uk-modal-container" uk-modal>
                      <div class="uk-modal-dialog uk-modal-body">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <h2 class="uk-modal-title">@lang('coupons.coupon-details')</h2>
                        <div class="uk-overflow-auto">
                          <table class="uk-table uk-table-striped" uk-table>
                            <thead>
                              <tr>
                                <th class="uk-text-center">#</th>
                                <th class="uk-text-center">@lang('coupons.client')</th>
                                <th class="uk-text-center">@lang('coupons.total')</th>
                                <th class="uk-text-center">@lang('coupons.comission')</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($coupon->orders as $order)
                                <tr>
                                  <td>{{ $loop->index+1}}</td>
                                  <td>{{ $order->client->user->first_name.' '.$order->client->user->last_name}}</td>
                                  <td>{{ $symbol }} {{ convertRate($order->price, $value) }}</td>
                                  <td>{{ $symbol }} {{ convertRate($order->comission, $value) }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </td> --}}
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      @else
        <div class="uk-h1 uk-text-center isee-bold isee-spacing-small">
          No tiene promociones asociadas.
        </div>
      @endif
    </div>
  </div>

@endsection
