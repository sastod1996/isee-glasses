@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Características
            <a href="{{ route('characteristics.create') }}" class="uk-button uk-background-primary uk-light">
              Nuevo Característica
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
              @foreach ($characteristics as $characteristic)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $characteristic->name }}</td>
                  <td>{{ $characteristic->slug }}</td>
                  <td class="fit">
                    <a class="uk-button uk-button-default"
                      href="{{ route('characteristics.edit', ['id' => $characteristic->id]) }}">
                      Editar
                    </a>
                  </td>
                  <td class="fit">
                    <a class="uk-button uk-button-danger"
                      href="{{ route('characteristics.destroy', ['id' => $characteristic->id]) }}"
                      data-method="delete"
                      data-confirm="¿Eliminar a {{ $characteristic->name }}?">
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

@endsection
