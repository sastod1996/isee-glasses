@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <ol class="breadcrumb">
              <li><a href="{{ route('home.admin') }}">Home</a></li>
              <li><a href="{{ route('users.index') }}">Usuarios</a></li>
            </ol>
          </div>
          <div class="panel-body">
            <h2>
              Lead <strong>{{ $user->name }}</strong>
            </h2>
            <hr>
            <div class="row">
              <div class="col-md-8 col-md-push-2">
                @include('admin.users._form', ['user' => $user])
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
