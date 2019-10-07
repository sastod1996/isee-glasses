{{-- Show clients - @LuceroL --}}
@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">
        <div class="">
          <div class="">
            <div class="uk-h2">
              Popups
              <a href="{{ route('popups.create') }}" class="uk-button uk-background-primary uk-light">Nuevo Popup</a>
            </div>
            <div class="uk-overflow-auto">
              <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Cupón</th>
                    <th>Descuento</th>
                    <th>Habilitado</th>
                    <th>Caducidad</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($popups as $popup)
                    <tr>
                      <td>{{ $loop->index+1 }}</td>
                      <td>{{ $popup->name }} </td>
                      <td>{{ $popup->coupon->code }}</td>
                      <td>{{ $popup->coupon->percent }}</td>
                      <td>{{ $popup->status == 1 ? 'SI' : 'NO' }}</td>
                      <td>{{ $popup->end_date }}</td>
                      <td>
                        <a class="uk-button uk-button-primary uk-light" href="{{ route('popups.edit', ['id' => $popup->id]) }}">Editar</a>
                        <a class="uk-button uk-button-default" href="{{ route('popups.show', ['id' => $popup->id]) }}">Ver</a>
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
