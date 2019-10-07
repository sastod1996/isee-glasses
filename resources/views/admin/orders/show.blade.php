@extends('layouts.admin')

@section('content')

  @php
    $symbol = 'S/.';
    $value = 1;
  @endphp

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Orden <strong>{{ $order->nro }}</strong>
          </div>
          @if (Session::has('prescription-status'))
            <div class="uk-alert-success" uk-alert>
              <a class="uk-alert-close" uk-close></a>
              <strong>{{Session::get('prescription-status')}}</strong>
            </div>
          @endif
          @if (Session::has('order-status'))
            <div class="uk-alert-success" uk-alert>
              <a class="uk-alert-close" uk-close></a>
              <strong>{{Session::get('order-status')}}</strong>
            </div>
          @endif
        </div>
        <div class="" uk-grid>
          <div class="uk-width-2-3">
            @if (Auth::user()->is_administrator())
              @include('admin.orders._form_admin', ['order' => $order, 'type' => $type])
            @endif
          </div>
          <div class="uk-width-1-3">
            <div class="uk-background-muted">
              <table class="uk-table">
                <thead>
                  <tr>
                    <th>Historial de estados</th>
                  </tr>
                </thead>
                @foreach ($order->states as $state)
                  <tr>
                    <td>{{ $state->name }}</td>
                    <td>{{ date('d/m/Y', strtotime($state->pivot->date)) }}</td>
                  </tr>
                @endforeach
              </table>

            </div>
            {{--  Historial de estado--}}
          </div>
        </div>
        <div class="">
          <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Prescripción</th>
                <th>Subtotal</th>
                <th>Descuento</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($order->products as $item)
                <tr>
                  <td class="uk-text-center">
                    <img class="" src="{{$item->image}}" alt="{{$item->slug}}" style="width: 200px;">
                    <p class="uk-text-bold">{{$item->code}}</p>
                  </td>
                  <td>
                    @php
                      $pack = \App\Pack::find($item->pivot->pack_id);
                      $type = \App\Type::find($item->pivot->type_id);
                      $pres = \App\Prescription::find($item->pivot->prescription_id);
                      $color = \App\Attribute::find($item->pivot->color_id);
                      $size = \App\Attribute::find($item->pivot->size_id);
                    @endphp
                    <p class="uk-text-uppercase"> <b>Color: </b> {{$color->name}}</p>
                    <p class="uk-text-uppercase"> <b>Tamaño: </b>{{$size->name}}</p>
                    <p class="uk-text-uppercase"> <b>Tipo + Paquete: </b>{{$type->name}} + {{$pack->name}}</p>
                    @if ($item->pivot->opt_id)
                      @php
                      $opt = \App\Option::find($item->pivot->opt_id);
                      @endphp
                      <p class="uk-text-uppercase"> <b>Adicionales: </b>{{$opt->name}}</p>
                    @endif
                    @if ($item->pivot->warranty_id)
                      @php
                      $warr = \App\Warranty::find($item->pivot->warranty_id);
                      @endphp
                      <p class="uk-text-uppercase"> <b>Garantía: </b>{{$warr->name}}</p>
                    @endif
                  </td>
                  <td>
                    @if (isset($pres))
                      <a class="uk-button uk-button-primary uk-light" href="#modal-example-{{ $pres->id }}" uk-toggle>Detalle</a>
                      <div id="modal-example-{{ $pres->id }}" class="uk-modal-container" uk-modal>
                      <div class="uk-modal-dialog">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <div class="uk-modal-header">
                          <h2 class="uk-modal-title uk-text-capitalize">{{ isset($pres) ? substr($pres->name,0,12) == 'isee-archivo' ? substr($pres->name,13) : $pres->name : ''}}</h2>
                        </div>
                        <form class="" action="{{route('orders.updatePrescription', ['order_id' => $item->pivot->order_id, 'product_id' => $item->pivot->product_id]) }}" method="post">
                          <div class="uk-modal-body">
                            {{ csrf_field() }}
                            {{-- <input type="hidden" name="_method" value="put"> --}}
                            <input type="hidden" name="code" value="{{$pres->code}}">
                            <input type="hidden" name="name" value="{{$pres->name}}">
                            <input type="hidden" name="description" value="{{$pres->description}}">
                            <input type="hidden" name="file" value="{{$pres->file}}">
                            <input type="hidden" name="status" value="{{$pres->status}}">
                            <input type="hidden" name="client_id" value="{{$pres->client_id}}">
                            <div class="">
                              @if ($pres->file)
                                <a class="uk-link-reset uk-text-bold" href="{{asset($pres->file)}}" target="_blank" type="button" >Ver archivo adjunto</a>
                              @endif
                            </div>
                            <div class="">
                              <table class="uk-table uk-table-responsive uk-table-middle">
                                <thead>
                                  <tr>
                                    <th class=""></th>
                                    <th class="">Esfera (ESF)</th>
                                    <th class="">Cilindro (CIL)</th>
                                    <th class="">Eje (AXI)</th>
                                    <th class="">Adición de cerca (ADD)</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>Ojo derecho (OD)</td>
                                    <td>
                                      <select name="esfod" class="uk-select">
                                        @for ($i=-10; $i <=8 ; $i=$i+0.25 )
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_esfod)
                                            selected
                                          @endif
                                          >{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                    <td>
                                      <select name="cilod" class="uk-select">
                                        @for ($i=-6; $i <=6 ; $i=$i+0.25 )
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_cilod)
                                            selected
                                          @endif>{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                    <td>
                                      <select name="axiod" class="uk-select">
                                        @for ($i=0; $i <=180 ; $i++)
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_axiod)
                                            selected
                                          @endif>{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                    <td>
                                      <select name="addod" class="uk-select">
                                        @for ($i=0; $i <=4 ; $i=$i+0.25 )
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_addod)
                                            selected
                                          @endif>{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Ojo izquierdo (OI)</td>
                                    <td>
                                      <select name="esfoi" class="uk-select">
                                        @for ($i=-10; $i <=8 ; $i=$i+0.25 )
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_esfoi)
                                            selected
                                          @endif>{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                    <td>
                                      <select name="ciloi" class="uk-select">
                                        @for ($i=-6; $i <=6 ; $i=$i+0.25)
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_ciloi)
                                            selected
                                          @endif>{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                    <td>
                                      <select name="axioi" class="uk-select">
                                        @for ($i=0; $i <=180 ; $i++)
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_axioi)
                                            selected
                                          @endif>{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                    <td>
                                      <select name="addoi" class="uk-select">
                                        @for ($i=0; $i <=4 ; $i=$i+0.25)
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_addoi)
                                            selected
                                          @endif>{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Distancia interpupilar (DIP)</td>
                                    <td>
                                      <select name="esfdip" class="uk-select">
                                        @for ($i=50; $i <=80 ; $i++)
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_esfdip)
                                            selected
                                          @endif>{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                    <td>
                                      <select name="dip" class="uk-select">
                                        @for ($i=50; $i <=80 ; $i++)
                                          <option value="{{$i}}"
                                          @if ($i == $item->pivot->pres_dip)
                                            selected
                                          @endif>{{$i}}</option>
                                        @endfor
                                      </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            @if ($pres->description)
                              <div class="">
                                <hr>
                              </div>
                              <div class="">
                                <p>
                                  <span class="uk-text-bold">Comentario del cliente: </span>
                                  {{ $pres->description }}
                                </p>
                              </div>
                            @endif
                          </div>
                          <div class="uk-modal-footer">
                            <div class="uk-text-right">
                              <button class="uk-button uk-button-default uk-modal-close" type="button">Cerrar</button>
                              <input type="submit" class="uk-button uk-button-primary uk-light" name="" value="Guardar">
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    @else
                      NO APLICA
                    @endif
                  </td>
                  <td>{{ $symbol }} {{ convertRate($item->pivot->subtotalprice, $value) }}</td>
                  <td>{{ $symbol }} {{ convertRate($item->pivot->discount, $value) }}</td>
                  <td>{{ $symbol }} {{ convertRate($item->pivot->totalprice, $value) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
