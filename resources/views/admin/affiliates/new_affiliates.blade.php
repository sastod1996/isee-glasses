@extends('layouts.admin')

@section('content')
  <div class="">
    <div class="">
      <div class="">
        <div class="">
          <div class="uk-h2">
            Solicitudes de Afiliación
          </div>
        </div>
        @if ($affiliates->count()>0)
          <div class="">
            <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Cliente</th>
                  @if (Auth::user()->is_administrator())
                    <th>Acciones</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach ($affiliates as $affiliate)
                  <tr>
                    <td>{{ $loop->index+1}}</td>
                    <td>{{$affiliate->user->first_name}} {{$affiliate->user->last_name}}</td>
                    <td class="fit">
                      <a class="uk-button uk-button-default" href="#details-affiliate-{{$affiliate->user_id}}" uk-toggle>Ver detalle</a>
                      <div id="details-affiliate-{{$affiliate->user_id}}" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                          <button class="uk-modal-close-default" type="button" uk-close></button>
                          <h2 class="uk-modal-title">{{ $affiliate->user->first_name}} {{ $affiliate->user->last_name}}</h2>
                          <form class="uk-form-horizontal">
                            <div class="uk-margin">
                              <label class="uk-form-label" for="dni">DNI</label>
                              <div class="uk-form-controls">
                                <input id="dni" class="uk-input" type="text" value="{{ $affiliate->dni}}" disabled >
                              </div>
                            </div>
                            <div class="uk-margin">
                              <label class="uk-form-label" for="facebook">Facebook</label>
                              <div class="uk-form-controls">
                                <input id="dni" class="uk-input" type="text" value="{{ $affiliate->facebook}}" disabled >
                              </div>
                            </div>
                            <div class="uk-margin">
                              <label class="uk-form-label" for="instagram">Instagram</label>
                              <div class="uk-form-controls">
                                <input id="instagram" class="uk-input" type="text" value="{{ $affiliate->instagram}}" disabled >
                              </div>
                            </div>
                            <div class="uk-margin">
                              <label class="uk-form-label" for="twitter">Twitter</label>
                              <div class="uk-form-controls">
                                <input id="twitter" class="uk-input" type="text" value="{{ $affiliate->twitter}}" disabled >
                              </div>
                            </div>
                            <div class="uk-margin">
                              <label class="uk-form-label" for="youtube">Youtube</label>
                              <div class="uk-form-controls">
                                <input id="youtube" class="uk-input" type="text" value="{{ $affiliate->youtube}}" disabled >
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </td>
                    <td class="fit">
                      <form class="" action="{{route('affiliates.update', ['id' => $affiliate->user_id])}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <input type="hidden" name="status" value="1">
                        <input class="uk-button uk-button-primary uk-light" type="submit" value="Confirmar">
                      </form>
                    </td>
                    <td class="fit">
                      <form class="" action="{{route('affiliates.update', ['id' => $affiliate->user_id])}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <input class="uk-button uk-button-danger" type="submit" value="Rechazar">
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
        <div class="">
          <p>No tiene nuevas solicitudes.</p>
        </div>
        @endif
      </div>
    </div>
  </div>

@endsection
