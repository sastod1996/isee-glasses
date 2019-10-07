@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Paquetes
            <a href="{{ route('packs.create') }}" class="uk-button uk-background-primary uk-light">
              Nuevo Paquete
            </a>
          </div>
        </div>
        <div class="">
          <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Slug</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($packs as $pack)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $pack->name }}</td>
                  <td>{{ $pack->slug }}</td>
                  <td class="fit">
                    <a class="uk-button uk-button-default"
                      href="{{ route('packs.edit', ['id' => $pack->id]) }}">
                      Editar
                    </a>
                  </td>
                  <td class="fit">
                    <a class="uk-button uk-button-danger"
                      href="{{ route('packs.destroy', ['id' => $pack->id]) }}"
                      data-method="delete"
                      data-confirm="¿Eliminar a {{ $pack->name }}?">
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
