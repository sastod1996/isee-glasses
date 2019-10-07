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
            {{ $title }}
          </div>
          <hr>
          @if ($orders->count()<=0)
            <div class="">
              <p>No hay registro de órdenes.</p>
            </div>
          @else
          <form action="{{ route('excel.export', ['type' => $type]) }}" method="GET" class="uk-form-horizontal" uk-grid>
            <div class="uk-margin-small uk-width-1-1 uk-text-center" uk-grid>
              <div class="uk-width-2-5 uk-width-1-1">
                <label class="uk-form-label" for="start_date">Fecha inicio</label>
                <div class="uk-form-controls">
                  <input class="uk-input" type="date" name="start_date" value="">
                </div>
              </div>
              <div class="uk-width-2-5 uk-width-1-1">
                <label class="uk-form-label" for="end_date">Fecha fin</label>
                <div class="uk-form-controls">
                  <input class="uk-input" type="date" name="end_date" value="">
                </div>
              </div>
              <div class="uk-width-expand uk-width-1-1">
                {{-- <a type="submit" class="uk-align-right uk-button uk-background-primary uk-light" href="{{ route('excel.export') }}">EXPORTAR</a> --}}
                <button type="submit" class="uk-align-center uk-button uk-background-primary uk-light">EXPORTAR</button>
              </div>
            </div>
          </form>
          <hr>
        </div>
        <div class="uk-align-center">
          <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
            <thead>
              <tr>
                <th class="uk-width-small">Nro. Órden</th>
                <th class="uk-table-shrink">Código rastreo</th>
                <th class="uk-width-small">Fecha orden (dd/mm/yy)</th>
                <th class="uk-width-small">Estado actual</th>
                <th class="uk-table-shrink">Fecha estado (dd/mm/yy)</th>
                <th class="uk-width-small">Subtotal</th>
                <th>Cupón</th>
                <th class="uk-table-shrink">Descuento total</th>
                <th class="uk-width-small">Total</th>
                @if (Auth::user()->is_administrator())
                <th>Acciones</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach ($orders as $order)
                <tr>
                  <th>{{ $order->nro }}</th>
                  <td>{{ $order->code }}</td>
                  {{-- <td>{{ $order->products->count() }}</td> --}}
                  <td>{{ date('d/m/Y', strtotime($order->date_order)) }}</td>
                  <td>{{ $order->getCurrentState()->name }}</td>
                  <td>{{ date('d/m/Y', strtotime($order->getCurrentState()->pivot->date)) }}</td>
                  <td>{{ $symbol }} {{ convertRate($order->subtotal, $value) }}</td>
                  <td>{{isset($order->coupon_id) ? $order->coupon->code : '-'}}</td>
                  <td>{{isset($order->coupon_id) || $order->discount > 0 ? $symbol.' '.convertRate($order->discount, $value) : '-'}}</td>
                  <td>{{ $symbol }} {{ convertRate($order->price, $value) }}</td>
                  @if (Auth::user()->is_administrator())
                    <td class="fit">
                      <a class="uk-button uk-button-primary uk-light uk-text-small"
                      href="{{ route('orders.showByStatus', ['id' => $order->id, 'type' => $type ]) }}">
                      Ver Orden
                      </a>
                    </td>
                    {{-- <td class="fit">
                      <a class="uk-button uk-button-danger"
                      href="{{ route('orders.destroy', ['id' => $order->id]) }}"
                      data-method="delete"
                      data-confirm="¿Eliminar a {{ $order->name }}?">
                      Eliminar
                      </a>
                    </td> --}}
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>
    </div>
  </div>

@endsection

@push('js')
  @if (Session::has('error'))
    <script>
    UIkit.notification({
      message: '<span uk-icon="icon: warning"></span> {{ Session::get('error') }}',
      status: 'danger',
      pos: 'bottom-center',
      timeout: 3000
    });
    </script>
  @endif
@endpush
