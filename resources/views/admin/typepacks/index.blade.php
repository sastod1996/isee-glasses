@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Tipo/Paquetes
            {{-- <a href="{{ route('typepacks.create') }}" class="uk-button uk-background-primary uk-light">
              Nuevo Tipo/Paquete
            </a> --}}
          </div>
        </div>
        <div class="">
          <div class="">
            <ul class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-fade">
              @foreach ($types as $type)
                <li><a href="#">{{ $type->name }}</a></li>
              @endforeach
            </ul>

            <ul class="uk-switcher uk-margin">
              @foreach ($types as $type)
                <li class="uk-flex uk-flex-center">
                  <div class="uk-width-2-5">
                    <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
                      <thead>
                        <tr>
                          <th>Paquete</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($type->typepacks as $typepack)
                          <tr>
                            <td>{{ $typepack->pack->name }}</td>
                            <td class="fit">
                              <a class="uk-button uk-button-default"
                              href="{{ route('typepacks.edit', ['id' => $typepack->id]) }}">
                              Editar
                              </a>
                            </td>
                            {{-- <td class="fit">
                              <a class="uk-button uk-button-danger" href="{{ route('typepacks.destroy', ['id' => $typepack->id]) }}" data-method="delete" data-confirm="¿Eliminar a {{ $typepack->id }}?">
                                Eliminar
                              </a>
                            </td> --}}
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </li>
              @endforeach
            </ul>
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
        pos: 'bottom-center'
      });
      </script>
    @endif
    @if (Session::has('danger'))
      <script>
      UIkit.notification({
        message: '<span uk-icon="icon: warning"></span> {{ Session::get('danger') }}',
        status: 'danger',
        pos: 'bottom-center'
      });
      </script>
    @endif
  @endpush

@endsection
