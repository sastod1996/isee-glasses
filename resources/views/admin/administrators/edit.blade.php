@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <ol class="breadcrumb">
              <li><a href="{{ route('home.admin') }}">Home</a></li>
              <li><a href="{{ route('administrators.index') }}">Administradores</a></li>
            </ol>
          </div>
          <div class="panel-body">
            <h2>
              Administrador <strong>{{ $administrator->name }}</strong>
            </h2>
            <hr>
            <div class="row">
              <div class="col-md-8 col-md-push-2">
                @include('admin.administrators._form', ['administrator' => $administrator])
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
