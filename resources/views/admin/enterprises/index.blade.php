@extends('layouts.admin')

@section('content')
  <div class="">
    <div class="">
      <div class="">
        <div class="uk-flex uk-flex-between">
          <div class="uk-h2">
            Empresas
          </div>
          <div class="">
            <a class="uk-button uk-button-default" href="{{ route('enterprises.create') }}">Crear empresa</a>
          </div>
        </div>
        <div class="">
          @if ($enterprises->count() <= 0)
            <div class="">
              No tiene empresas registrados.
            </div>
          @else
            <hr>
            <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre de la Empresa</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($enterprises as $enterprise)
                  <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $enterprise->name}} </td>
                    <td>
                      <a class="uk-button uk-button-primary" href="{{ route('enterprises.edit', $enterprise->id) }}">Editar</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

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
