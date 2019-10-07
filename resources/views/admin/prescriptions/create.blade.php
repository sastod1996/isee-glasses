@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Nueva prescripción
          </div>
          <div class="">
            @if (Auth::user()->is_administrator())
              @include('admin.prescriptions._form_admin', ['clients', $clients])
            @else
              @include('admin.prescriptions._form_client')
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
