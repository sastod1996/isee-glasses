@extends('layouts.admin')

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <ol class="breadcrumb">
              <li><a href="{{ route('home.admin') }}">Home</a></li>
              <li class="active">Roles</li>
            </ol>
          </div>
          <div class="panel-body">
            <h2>
              Roles
              {{-- <a href="{{ route('roles.create') }}" class="btn btn-success">
                Nueva Característica de lentes
              </a> --}}
            </h2>
            <hr>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-middle">
                <thead>
                  <tr>
                    <th class="col-md-1" rowspan="2">#</th>
                    <th class="col-md-3" rowspan="2">Nombre</th>
                    <th colspan="1" rowspan="2">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($roles as $role)
                    <tr>
                      <th>{{ $loop->index+1 }}</th>
                      <td>{{ $role->name }}</td>
                      {{-- <td class="fit">
                        <a class="btn btn-default"
                          href="{{ route('roles.edit', ['id' => $role->id]) }}">
                          Editar
                        </a>
                      </td> --}}
                      <td class="fit">
                        <a class="btn btn-danger"
                          href="{{ route('roles.destroy', ['id' => $role->id]) }}"
                          data-method="delete"
                          data-confirm="¿Eliminar a {{ $role->name }}?">
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
