@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Prescripciones
            <a href="{{ route('prescriptions.create') }}" class="uk-button uk-background-primary uk-light">
              Nuevo Prescripción
            </a>
          </div>
        </div>
        <div class="">
          <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
            <thead>
              <tr>
                <th>#</th>
                <th>Código</th>
                <th>Usuario</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($prescriptions as $prescription)
                <tr>
                  <th>{{ $loop->index+1 }}</th>
                  <td>{{ $prescription->code }}</td>
                  <td>{{ $prescription->client->user->first_name.' '.$prescription->client->user->last_name }}</td>
                  <td class="fit">
                    <a class="uk-button uk-button-default"
                      href="#prescription-details-{{ $prescription->slug }}" uk-toggle>
                      Detalles
                    </a>
                    <div id="prescription-details-{{ $prescription->slug }}" uk-modal>
                      <div class="uk-modal-dialog uk-modal-body">
                        <h2 class="uk-modal-title">Headline</h2>
                        <p>
                          <table class="uk-table uk-table-divider">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Esfera (ESF)</th>
                                <th>Cilindro (CIL)</th>
                                <th>Eje (AXI)</th>
                                <th>Adición de cerca (ADD)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Ojo derecho (OD)</td>
                                <td>{{ $prescription->esfod }}</td>
                                <td>{{ $prescription->cilod }}</td>
                                <td>{{ $prescription->axiod }}</td>
                                <td>{{ $prescription->addod }}</td>
                              </tr>
                              <tr>
                                <td>Ojo izquierdo (OI)</td>
                                <td>{{ $prescription->esfoi }}</td>
                                <td>{{ $prescription->ciloi }}</td>
                                <td>{{ $prescription->axioi }}</td>
                                <td>{{ $prescription->addoi }}</td>
                              </tr>
                              <tr>
                                <td>Distancia interpupilar</td>
                                <td>{{ $prescription->esfdip }}</td>
                                <td>{{ $prescription->dip }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </p>
                        <p class="uk-text-right">
                          <button class="uk-button uk-button-default uk-modal-close" type="button">Cerrar</button>
                        </p>
                      </div>
                    </div>
                  </td>
                  <td class="fit">
                    <a class="uk-button uk-button-primary uk-light"
                      href="{{ route('prescriptions.edit', ['id' => $prescription->id]) }}">
                      Editar
                    </a>
                  </td>
                  <td class="fit">
                    <a class="uk-button uk-button-danger"
                      href="{{ route('prescriptions.destroy', ['id' => $prescription->id]) }}"
                      data-method="delete"
                      data-confirm="¿Eliminar a {{ $prescription->name }}?">
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

  @push('js')
    @if (Session::has('success'))
      <script>
      UIkit.notification({
        message: '<span uk-icon="icon: check"></span> {{ Session::get('success') }}',
        status: 'success',
        pos: 'bottom-center',
        timeout: 3000
      });
      </script>
    @endif
    @if (Session::has('danger'))
      <script>
      UIkit.notification({
        message: '<span uk-icon="icon: warning"></span> {{ Session::get('danger') }}',
        status: 'danger',
        pos: 'bottom-center',
        timeout: 3000
      });
      </script>
    @endif
  @endpush

@endsection
