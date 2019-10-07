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
          <div class="">
            <div class="uk-h2">
              Cupones
              <a href="{{ route('coupons.create') }}" class="uk-button uk-background-primary uk-light">
                Nuevo Cupón
              </a>
            </div>
            <div class="uk-overflow-auto">
              <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
                <thead>
                  <tr>
                    {{-- <th>#</th> --}}
                    <th class="uk-text-center uk-table-shrink">Cód</th>
                    <th class="uk-text-center uk-width-small">Afiliado</th>
                    <th class="uk-text-center uk-table-shrink">Porcentaje (%)</th>
                    <th class="uk-text-center uk-table-shrink">Estado pago</th>
                    <th class="uk-text-center uk-width-small">Fecha Inicio (dd/mm/yy)</th>
                    <th class="uk-text-center uk-width-small">Fecha Fin (dd/mm/yy)</th>
                    {{-- <th class="uk-text-center ">N° Uso</th> --}}
                    <th class="uk-text-center uk-table-shrink">Comisión a pagar</th>
                    <th class="uk-text-center ">Estado</th>
                    <th class="uk-text-center uk-table-shrink">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $now = Carbon\Carbon::now()->format('Y-m-d');
                  @endphp
                  @foreach ($coupons as $coupon)
                    <tr>
                      {{-- <th>{{ $loop->index+1 }}</th> --}}
                      <td>{{ $coupon->code }}</td>
                      <td>{{ $coupon->affiliate_id ? $coupon->affiliate->user->first_name.' '.$coupon->affiliate->user->last_name : 'No aplica'}}</td>
                      <td>{{ $coupon->percent }} %</td>
                      <td>{{ $coupon->affiliate_id ? $coupon->payment_status == 0 ? 'Pendiente' : 'Pagado' : 'No aplica' }}</td>
                      <td>{{ date('d/m/Y', strtotime($coupon->start_date)) }}</td>
                      <td class="
                        @if ($coupon->end_date < $now )
                          uk-text-danger uk-text-bold
                        @endif
                      ">
                        {{ date('d/m/Y', strtotime($coupon->end_date)) }}
                      </td>
                      {{-- <td>{{ $coupon->count }}</td> --}}
                      <td>{{isset($coupon->comission_total) ? $symbol.' '.convertRate($coupon->comission_total, $value) : $symbol.' 0.00' }}</td>
                      <td>{{ $coupon->status == 1 ? 'Activo' : 'Inactivo' }}</td>
                      <td class="fit">
                        <a class="uk-button uk-button-default uk-text-small"
                          href="{{ route('coupons.show', ['id' => $coupon->id]) }}">
                          VER ORDENES
                        </a>
                      </td>
                      <td class="fit">
                        <a class="uk-button uk-button-primary uk-light"
                          href="{{ route('coupons.edit', ['id' => $coupon->id]) }}">
                          Editar
                        </a>
                      </td>
                      <td class="fit">
                        <a class="uk-button uk-button-danger"
                          href="{{ route('coupons.destroy', ['id' => $coupon->id]) }}"
                          data-method="delete"
                          data-confirm="¿Eliminar a {{ $coupon->code }}?">
                          Eliminar
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('js')
    @if (Session::has('success'))
      <script>
      UIkit.notification({
        message: '<span uk-icon="icon: check"></span> {{ Session::get('success') }}',
        status: 'success',
        pos: 'bottom-center',
        timeout: 3000
      });
      </script>
    @endif
    @if (Session::has('danger'))
      <script>
      UIkit.notification({
        message: '<span uk-icon="icon: warning"></span> {{ Session::get('danger') }}',
        status: 'danger',
        pos: 'bottom-center',
        timeout: 3000
      });
      </script>
    @endif
  @endpush

@endsection

@push('js')
  @if (session('error'))
    <script type="text/javascript">
      UIkit.notification({
        message: '<i uk-icon="icon: check"></i> {{ session('error')}}',
        status: 'danger',
        pos: 'bottom-center',
        timeout: 5000
      })
    </script>
  @endif
@endpush
