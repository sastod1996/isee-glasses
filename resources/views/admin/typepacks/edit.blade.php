@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar Tipo/Paquete de <strong>{{ $typepack->type->name.' y '.$typepack->pack->name }}</strong>
          </div>
          <div class="">
            @include('admin.typepacks._form', ['typepack' => $typepack])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
