@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar característica <strong>{{ $characteristic->name }}</strong>
          </div>
          <div class="">
            @include('admin.characteristics._form', ['characteristic' => $characteristic])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
