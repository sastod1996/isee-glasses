@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar orden <strong>{{ $orden->name }}</strong>
          </div>
          <div class="">
            @if (Auth::user()->is_administrator())
              @include('admin.orders._form_admin', ['order' => $order])
            @else
              @include('admin.orders._form_client', ['order' => $order])
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
