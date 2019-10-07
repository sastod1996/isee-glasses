@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Sliders
            <a href="{{ route('sliders.create') }}" class="uk-button uk-background-primary uk-light">
              Nuevo Slider
            </a>
          </div>
        </div>
        <div class="uk-margin uk-flex uk-flex-center">
          <div class="uk-width-2-3">
            <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Imagen</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($sliders as $slider)
                  <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>
                      <img width="150" src="{{ $slider->image }}" alt="">
                    </td>
                    <td>
                      @if ($slider->status == '1')
                        <span class="uk-text-bold uk-text-success">Activo</span>
                      @else
                        <span class="uk-text-bold uk-text-danger">Inactivo</span>
                      @endif
                    </td>
                    <td class="fit">
                      <a class="uk-button uk-button-default" href="{{ route('sliders.edit', ['id' => $slider->id]) }}">
                        Editar
                      </a>
                    </td>
                    @if ($loop->index > 2)
                      <td class="fit">
                        <a class="uk-button uk-button-danger" href="{{ route('sliders.destroy', ['id' => $slider->id]) }}" data-method="delete" data-confirm="¿Eliminar a {{ $slider->name }}?">
                          Eliminar
                        </a>
                      </td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
            </table>
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
