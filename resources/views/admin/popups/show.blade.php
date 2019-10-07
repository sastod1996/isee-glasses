@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">
        <div class="uk-margin">
          <div class="uk-h2">
            Detalle del Popup "<strong>{{ $popup->name }}</strong>"
            <div class="uk-align-right">
              <a class="uk-button uk-button-default" href="{{ route('popups.index') }}">REGRESAR</a>
            </div>
          </div>
        </div>
        <div class="uk-margin-large">
          <div class="">
            <form class="uk-form-horizontal uk-width-1-1" uk-grid>
              <div class="uk-width-1-2@m uk-width-1-1">
                <label for="name" class="uk-form-label">Nombre</label>
                <div class="uk-form-controls">
                  <input name="name" type="text" id="name" class="uk-input" value="{{ $popup->name }}" disabled>
                </div>
              </div>

              <div class="uk-width-1-2@m uk-width-1-1">
                <label for="title" class="uk-form-label">Título</label>
                <div class="uk-form-controls">
                  <input name="title" type="text" id="title" class="uk-input" value="{{ $popup->title }}" disabled>
                </div>
              </div>

              <div class="uk-width-1-2@m uk-width-1-1">
                <label for="cupon_id" class="uk-form-label">Cupón</label>
                <div class="uk-form-controls">
                  <input name="title" type="text" id="cupon_id" class="uk-input" value="{{ $popup->coupon->code }}" disabled>
                </div>
              </div>

              <div class="uk-width-1-2@m uk-width-1-1">
                <label for="text_close" class="uk-form-label">Texto cerrar</label>
                <div class="uk-form-controls">
                  <input name="text_close" type="text" id="text_close" class="uk-input" value="{{ $popup->text_close }}" disabled>
                </div>
              </div>

              <div class="uk-width-1-2@m uk-width-1-1">
                <label for="text_main" class="uk-form-label">Texto Principal</label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea" name="text_main" rows="4" disabled>{{ $popup->text_main }}</textarea>
                </div>
              </div>

              <div class="uk-width-1-2@m uk-width-1-1">
                <label for="text_secondary" class="uk-form-label">Texto Secundario</label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea" name="text_secondary" rows="4" disabled>{{ $popup->text_secondary }}</textarea>
                </div>
              </div>

              <div class="uk-width-1-1">
                <label for="text_main" class="uk-form-label">Mensaje de presentación</label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea" name="text_main" rows="3" disabled>{{ $popup->message_presentation }}</textarea>
                </div>
              </div>

              <div class="uk-width-1-1">
                <label for="text_secondary" class="uk-form-label">Mensaje del cupón</label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea" name="text_secondary" rows="3" disabled>{{ $popup->message_coupon }}</textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="uk-margin">
          @if ($popup->interesados->count()<=0)
            <p>No existen interesados para este popup</p>
          @else
            <div class="">
              <div class="">
                <h3 class="uk-text-uppercase uk-text-bold">Sección de interesados</h3>
              </div>
              <div class="uk-margin-medium">
                <form action="{{ route('excel.export-interesados')}}" method="GET" class="uk-form-horizontal" uk-grid>
                  <div class="uk-width-2-5@m uk-width-1-1">
                    <label class="uk-form-label" for="start_date">Fecha inicio</label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="date" name="start_date" value="">
                    </div>
                  </div>
                  <div class="uk-width-2-5@m uk-width-1-1">
                    <label class="uk-form-label" for="end_date">Fecha fin</label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="date" name="end_date" value="">
                    </div>
                  </div>
                  <div class="uk-width-1-5@m uk-width-1-1">
                    <button type="submit" class="uk-button uk-background-primary uk-light uk-width-1-1">EXPORTAR</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="uk-margin">
              <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Fecha de solicitud</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($popup->interesados as $interesado)
                    <tr>
                      <td>{{ $loop->index+1 }}</td>
                      <td>{{ $interesado->name }}</td>
                      <td>{{ $interesado->telephone }}</td>
                      <td>{{ $interesado->email }}</td>
                      <td>{{ $interesado->created_at }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

@endsection

@push('js')
  @if (Session::has('error'))
    <script>
    UIkit.notification({
      message: '<span uk-icon="icon: warning"></span> {{ Session::get('error') }}',
      status: 'danger',
      pos: 'bottom-center',
      timeout: 3000
    });
    </script>
  @endif
@endpush
