@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Atributos
            {{-- <a href="{{ route('attributes.create') }}" class="uk-button uk-background-primary uk-light">
              Nuevo Atributo
            </a> --}}
          </div>
        </div>
        <div class="">
          <div class="">
            <ul class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-fade">
              @foreach ($characteristics as $characteristic)
                @if (isset($charSelected))
                  @if ($characteristic->id == $charSelected)
                    <li class="uk-active" aria-expanded="true"><a href="#">{{ $characteristic->name }}</a></li>
                  @else
                    <li aria-expanded="false"><a href="#">{{ $characteristic->name }}</a></li>
                  @endif
                @else
                  <li aria-expanded="false"><a href="#">{{ $characteristic->name }}</a></li>
                @endif
              @endforeach
            </ul>

            <ul class="uk-switcher uk-margin">
              @foreach ($characteristics as $characteristic)
                @if (isset($charSelected))
                  @if ($characteristic->id == $charSelected)
                    <li class="uk-flex uk-flex-center uk-active" aria-expanded="true">
                  @else
                    <li class="uk-flex uk-flex-center" aria-expanded="false">
                  @endif
                @else
                  <li class="uk-flex uk-flex-center" aria-expanded="false">
                @endif
                  <div class="uk-width-2-3">
                    <div class="uk-text-center">
                      <a class="uk-button uk-background-primary uk-light" href="/admin/attributes/characteristic/{{ $characteristic->id }}">Crear nuevo {{ $characteristic->name }}</a>
                    </div>
                    <div class="uk-margin-medium">
                      <form class="" action="/admin/search/attributes" method="get">
                        <div class="" uk-grid>
                          <input type="hidden" name="characteristic_id" value="{{ $characteristic->id }}">
                          <div class="uk-width-1-5 uk-flex uk-flex-middle">
                            <span>Buscar atributo:</span>
                          </div>
                          <div class="uk-width-3-5">
                            <input class="uk-input" name="like" type="text">
                          </div>
                          <div class="uk-width-1-5">
                            <button class="uk-button uk-button-secondary uk-width-1-1" type="submit">Buscar</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
                      <thead>
                        <tr>
                          <th class="uk-width-large">Nombre</th>
                          <th class="uk-width-small">
                            @if ($characteristic->slug == 'marca') Premium
                            @elseif ($characteristic->slug == 'color') Color Primario
                            @endif
                          </th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (isset($newAttributes) && $charSelected == $characteristic->id)
                          @foreach ($newAttributes as $attribute)
                            <tr>
                              <td>{{ $attribute->name }}</td>
                              <td>
                                @if ($characteristic->slug == 'marca')
                                  {{ $attribute->premium == 1 ? 'SI' : 'NO' }}
                                @elseif ($characteristic->slug == 'color')
                                  {{ $attribute->primary }}
                                @endif
                              </td>
                              {{-- <td class="fit">
                                <a class="uk-button uk-button-default" href="{{ route('attributes.edit', ['id' => $attribute->id]) }}">
                                  Editar
                                </a>
                              </td> --}}
                              <td class="fit">
                                <a class="uk-button uk-button-default" href="/admin/attributes/characteristic/{{ $characteristic->id }}/edit/{{ $attribute->id }}">
                                  Editar
                                </a>
                              </td>
                              {{-- <td class="fit">
                                <a class="uk-button uk-button-danger" href="{{ route('attributes.destroy', ['id' => $attribute->id]) }}" data-method="delete" data-confirm="¿Eliminar a {{ $attribute->name }}?">
                                  Eliminar
                                </a>
                              </td> --}}
                            </tr>
                          @endforeach
                        @else
                          @foreach ($characteristic->attributes as $attribute)
                            <tr>
                              <td>{{ $attribute->name }}</td>
                              <td>
                                @if ($characteristic->slug == 'marca')
                                  {{ $attribute->premium == 1 ? 'SI' : 'NO' }}
                                @elseif ($characteristic->slug == 'color')
                                  {{ $attribute->primary }}
                                @endif
                              </td>
                              {{-- <td class="fit">
                                <a class="uk-button uk-button-default" href="{{ route('attributes.edit', ['id' => $attribute->id]) }}">
                                  Editar
                                </a>
                              </td> --}}
                              <td class="fit">
                                <a class="uk-button uk-button-default" href="/admin/attributes/characteristic/{{ $characteristic->id }}/edit/{{ $attribute->id }}">
                                  Editar
                                </a>
                              </td>
                              {{-- <td class="fit">
                                <a class="uk-button uk-button-danger" href="{{ route('attributes.destroy', ['id' => $attribute->id]) }}" data-method="delete" data-confirm="¿Eliminar a {{ $attribute->name }}?">
                                  Eliminar
                                </a>
                              </td> --}}
                            </tr>
                          @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
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
        pos: 'bottom-center'
      });
      </script>
    @endif
    @if (Session::has('danger'))
      <script>
      UIkit.notification({
        message: '<span uk-icon="icon: warning"></span> {{ Session::get('danger') }}',
        status: 'danger',
        pos: 'bottom-center'
      });
      </script>
    @endif
  @endpush

@endsection
