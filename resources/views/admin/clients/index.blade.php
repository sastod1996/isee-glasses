{{-- Show clients - @LuceroL --}}
@extends('layouts.admin')

@section('content')
  <div class="">
    <div class="">
      @if (Session::has('clients_warnings'))
        <div class="uk-alert uk-alert-warning" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <h3 class="uk-margin-small">Hubo errores al crear los siguientes clientes</h3>
          <ul class="uk-margin-small">
            @foreach (Session::get('clients_warnings') as $key)
              <li>{{ $key->first_name.' '.$key->last_name.' - '.$key->email }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="">
        <div class="uk-flex uk-flex-between">
          <div class="uk-h2">
            Clientes
          </div>
          <div class="">
            <a class="uk-button uk-button-default" href="{{ route('clients.create') }}">Crear Cliente</a>
            <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #modal-import-clients">Importar clientes</button>
            <div id="modal-import-clients" uk-modal>
              <form class="uk-modal-dialog" action="{{ route('excel.import-clients') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                  <h2 class="uk-modal-title">Importar clientes</h2>
                </div>
                <div class="uk-modal-body">
                  <p>Selecciona un archivo Excel.</p>
                  <input type="file" name="excel">
                </div>
                <div class="uk-modal-footer" >
                  <div class="uk-child-width-expand" uk-grid>
                    <div>
                      <div class="uk-hidden" id="spinner">
                        Cargando...
                        <span uk-spinner></span>
                      </div>
                    </div>
                    <div>
                      <button id="cancelimport" class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                      <button id="sendimport" class="uk-button uk-button-primary uk-light" type="submit">Subir</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="">
          @if ($clients->count() <= 0)
            <div class="">
              No tiene clientes registrados.
            </div>
          @else
            <hr>
            <div class="">
              <form action="{{ route('excel.export-clients')}}" method="GET" class="uk-form-horizontal" uk-grid>
                <div class="uk-margin-small uk-width-1-1 uk-text-center" uk-grid>
                  <div class="uk-width-2-5 uk-width-1-1">
                    <label class="uk-form-label" for="start_date">Fecha inicio</label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="date" name="start_date" value="">
                    </div>
                  </div>
                  <div class="uk-width-2-5 uk-width-1-1">
                    <label class="uk-form-label" for="end_date">Fecha fin</label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="date" name="end_date" value="">
                    </div>
                  </div>
                  <div class="uk-width-expand uk-width-1-1">
                    <button type="submit" class="uk-align-center uk-button uk-background-primary uk-light">EXPORTAR USUARIOS</button>
                  </div>
                </div>
              </form>
            </div>
            <hr>
            <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
              <thead>
                <tr>
                  <th class="uk-width-auto">#</th>
                  <th class="uk-width-small">Nombres</th>
                  <th class="uk-width-small">Apellidos</th>
                  <th class="uk-width-small">DNI</th>
                  <th class="uk-width-small">Correo</th>
                  <th class="uk-width-small">Con convenio</th>
                  <th class="uk-table-small">Es afiliado</th>
                  <th class="uk-table-small">Tiene ME GUSTA</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($clients as $client)
                  <tr>
                    <td>{{ $loop->index+1 + 20 * ($clients->currentPage()-1) }}</td>
                    <td>{{ $client->user->first_name}} </td>
                    <td>{{ $client->user->last_name }}</td>
                    <td>{{ $client->dni }}</td>
                    <td>{{ $client->user->email }}</td>
                    <td class="{{ $client->ally ? 'uk-text-success' : 'uk-text-danger' }}">{{ $client->ally ? 'Sí' : 'No' }}</td>
                    <td>{{ $client->status_affiliate == 1 ? 'SI' : 'NO' }}</td>
                    <td>{{ $client->hasWishes > 0 ? 'SI' : 'NO' }}</td>
                    {{-- <td class="fit">
                      <a class="uk-button uk-button-secondary" href="#details-client-{{ $client->user_id }}" uk-toggle>Ver</a>
                      <div id="details-client-{{ $client->user_id }}" class="uk-modal-container" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                          <button class="uk-modal-close-default" type="button" uk-close></button>
                          <h3 class="uk-modal-title">Detalles del cliente</h3>
                          <form class="uk-form-horizontal uk-margin" uk-grid>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="first_name">Nombres</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="first_name" value="{{ $client->user->first_name }}" readonly >
                              </div>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="last_name">Apellidos</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="last_name" value="{{ $client->user->last_name }}" readonly >
                              </div>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="dni">DNI</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="dni" value="{{ $client->dni }}" readonly >
                              </div>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="last_name">Email</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="email" value="{{ $client->user->email }}" readonly >
                              </div>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="country">País</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="country" value="{{ $client->country }}" readonly >
                              </div>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="city">Ciudad</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="city" value="{{ $client->city }}" readonly >
                              </div>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="district">Distrito</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="district" value="{{ $client->district }}" readonly >
                              </div>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="code_postal">Cod. Postal</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="code_postal" value="{{ $client->code_postal }}" readonly >
                              </div>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="address">Dirección</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="address" value="{{ $client->address }}" readonly >
                              </div>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-1">
                              <label class="uk-form-label" for="reference">Referencia</label>
                              <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="reference" value="{{ $client->reference }}" readonly >
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </td> --}}

                    <td class="fit">
                      <a class="uk-button uk-button-primary" href="{{ route('clients.edit', $client->user_id) }}">Editar</a>
                    </td>

                    {{-- <td class="fit">
                      <a class="uk-width-small uk-button uk-button-danger"
                        href="{{ route('clients.destroy', ['id' => $client->id]) }}"
                        data-method="delete"
                        data-confirm="¿Eliminar al cliente {{ $client->user->first_name.' '.$client->user->last_name }}?">
                        Eliminar
                      </a>
                    </td> --}}
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="uk-flex uk-flex-center">
              {{$clients->render()}}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
  $(document).ready(function () {
    $("#sendimport").click(function () {
      $("#spinner").removeClass("uk-hidden")
    })
  })
  </script>
  @if (Session::has('success'))
    <script>
    UIkit.notification({
      message: '<span uk-icon="icon: check"></span> {{ Session::get('success') }}',
      status: 'success',
      pos: 'bottom-center',
      timeout: 5000
    });
    </script>
  @endif
  @if (Session::has('danger'))
    <script>
    UIkit.notification({
      message: '<span uk-icon="icon: warning"></span> {{ Session::get('danger') }}',
      status: 'danger',
      pos: 'bottom-center',
      timeout: 5000
    });
    </script>
  @endif
@endpush
