@extends('layouts.admin')

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <ol class="breadcrumb">
              <li><a href="{{ route('home.admin') }}">Home</a></li>
              <li class="active">Usuarios</li>
            </ol>
          </div>
          <div class="panel-body">
            <h2>
              Usuarios
              <a href="{{ route('users.create') }}" class="btn btn-success">
                Nuevo Usuario
              </a>
            </h2>
            <hr>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-middle">
                <thead>
                  <tr>
                    <th class="col-md-1" rowspan="2">#</th>
                    <th class="col-md-4" rowspan="2">Nombre</th>
                    <th class="col-md-3" rowspan="2">Email</th>
                    <th class="col-md-3" rowspan="2">Teléfono</th>
                    <th colspan="2" rowspan="2">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                    <tr>
                      <th>{{ $loop->index+1 }}</th>
                      <td>{{ $user->first_name.' '.$user->last_name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->telephone }}</td>
                      <td class="fit">
                        <a class="btn btn-default"
                          href="{{ route('users.edit', ['id' => $user->id]) }}">
                          Editar
                        </a>
                      </td>
                      <td class="fit">
                        <a class="btn btn-danger"
                          href="{{ route('users.destroy', ['id' => $user->id]) }}"
                          data-method="delete"
                          data-confirm="¿Eliminar a {{ $user->name }}?">
                          Eliminar
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
