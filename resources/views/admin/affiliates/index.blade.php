@extends('layouts.admin')

@section('content')
  <div class="">
    <div class="">
      <div class="">
        <div class="">
          <div class="uk-h2">
            Afiliados
            {{-- <a href="{{ route('affiliates.create') }}" class="uk-button uk-background-primary uk-light">
              Nuevo Afiliado
            </a> --}}
          </div>
        </div>
        <div class="">
          @if ($affiliates->count() <= 0)
            <div class="">
              No tiene afiliados.
            </div>
          @else
            <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Cliente</th>
                  <th>DNI</th>
                  <th>Redes Sociales</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($affiliates as $affiliate)
                  <tr>
                    <td>{{ $loop->index+1}}</td>
                    <td>{{ $affiliate->user->first_name}} {{$affiliate->user->last_name}}</td>
                    <td>{{ $affiliate->dni}}</td>
                    <td>
                      <ul class="uk-list">
                        @if (isset( $affiliate->facebook))
                          <li><b>Facebook:</b> <a href="{{ $affiliate->facebook }}">{{ $affiliate->facebook }}</a></li>
                        @endif
                        @if (isset( $affiliate->instagram))
                          <li><b>Instagram:</b> <a href="{{ $affiliate->instagram }}">{{ $affiliate->instagram }}</a></li>
                        @endif
                        @if (isset( $affiliate->twitter))
                          <li><b>Twitter:</b> <a href="{{ $affiliate->twitter }}">{{ $affiliate->twitter }}</a></li>
                        @endif
                        @if (isset( $affiliate->youtube))
                          <li><b>Youtube:</b> <a href="{{ $affiliate->youtube }}">{{ $affiliate->youtube }}</a></li>
                        @endif
                      </ul>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>
    </div>
  </div>

@endsection
