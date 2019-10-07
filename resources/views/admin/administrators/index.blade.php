@extends('layouts.admin')

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <ol class="breadcrumb">
              <li><a href="{{ route('home.admin') }}">Home</a></li>
              <li class="active">Administradores</li>
            </ol>
          </div>
          <div class="panel-body">
            <h2>
              Administradores
              <a href="{{ route('administrators.create') }}" class="btn btn-success">
                Nuevo Administrador
              </a>
            </h2>
            <hr>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-middle">
                <thead>
                  <tr>
                    <th class="col-md-1" rowspan="2">#</th>
                    <th class="col-md-3" rowspan="2">Nombre</th>
                    <th class="col-md-3" rowspan="2">Email</th>
                    <th colspan="2" rowspan="2">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($administrators as $administrator)
                    <tr>
                      <th>{{ $loop->index+1 }}</th>
                      <td>{{ $administrator->user->first_name.' '.$administrator->user->last_name }}</td>
                      <td>{{ $administrator->user->email }}</td>
                      <td class="fit">
                        <a class="btn btn-default"
                          href="{{ route('administrators.edit', ['id' => $administrator->user_id]) }}">
                          Editar
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
