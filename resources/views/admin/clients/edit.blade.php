@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar cliente <strong>{{ $user->first_name.' '.$user->last_name }}</strong>
          </div>
          <div class="">
            @include('admin.clients._form', ['user' => $user, 'backTo' => $backTo])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
