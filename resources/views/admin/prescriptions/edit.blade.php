@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar prescripción <strong>{{ $prescription->name }}</strong>
          </div>
          <div class="">
            @include('admin.prescriptions._form', ['prescription' => $prescription])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
