@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar tipo <strong>{{ $type->name }}</strong>
          </div>
          <div class="">
            @include('admin.types._form', ['type' => $type])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
