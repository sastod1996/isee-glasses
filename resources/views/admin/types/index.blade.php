@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Tipos
            <a href="{{ route('types.create') }}" class="uk-button uk-background-primary uk-light">
              Nuevo Tipo
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
              @foreach ($types as $type)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $type->name }}</td>
                  <td>{{ $type->slug }}</td>
                  <td class="fit">
                    <a class="uk-button uk-button-default"
                      href="{{ route('types.edit', ['id' => $type->id]) }}">
                      Editar
                    </a>
                  </td>
                  <td class="fit">
                    <a class="uk-button uk-button-danger"
                      href="{{ route('types.destroy', ['id' => $type->id]) }}"
                      data-method="delete"
                      data-confirm="¿Eliminar a {{ $type->name }}?">
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
