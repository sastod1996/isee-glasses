@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar paquete <strong>{{ $pack->name }}</strong>
          </div>
          <div class="">
            @include('admin.packs._form', ['pack' => $pack])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
