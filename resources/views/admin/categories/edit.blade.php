@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar categoría <strong>{{ $category->name }}</strong>
          </div>
          <div class="">
            @include('admin.categories._form', ['category' => $category])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
