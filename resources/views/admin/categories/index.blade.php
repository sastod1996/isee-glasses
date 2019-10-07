@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Categorías
            <a href="{{ route('categories.create') }}" class="uk-button uk-background-primary uk-light">
              Nueva Categoría
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
              @foreach ($categories as $category)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $category->name }}</td>
                  <td>{{ $category->slug }}</td>
                  <td class="fit">
                    <a class="uk-button uk-button-default"
                      href="{{ route('categories.edit', ['id' => $category->id]) }}">
                      Editar
                    </a>
                  </td>
                  <td class="fit">
                    <a class="uk-button uk-button-danger"
                      href="{{ route('categories.destroy', ['id' => $category->id]) }}"
                      data-method="delete"
                      data-confirm="¿Eliminar a {{ $category->name }}?">
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
