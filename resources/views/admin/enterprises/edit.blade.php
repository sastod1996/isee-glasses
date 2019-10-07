@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar empresa <strong>{{ $enterprise->name }}</strong>
          </div>
          <div class="">
            @include('admin.enterprises._form', ['enterprise' => $enterprise])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
