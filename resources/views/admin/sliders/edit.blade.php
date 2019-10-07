@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar slider <strong>{{ $slider->name }}</strong>
          </div>
          <div class="">
            @include('admin.sliders._form', ['slider' => $slider])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
