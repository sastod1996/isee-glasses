@push('css')
  <link rel="stylesheet" href="/css/admin/pages/products.css">
@endpush

@extends('layouts.admin')


@section('content')

  <div class="">
    <div class="">
      @if (Session::has('products'))
        <div class="uk-alert uk-alert-danger" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <h3>Error</h3>
          <p>Error en los productos con códigos: {{ join(', ', explode(';', Session::get('products'))) }}</p>
        </div>
      @endif
      <div class="">
        <div class="uk-h2">
          Detalle de <strong>{{ $product->name }}</strong>
        </div>
        <div class="uk-background-muted uk-padding">
          <div class="" uk-grid>
            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-child-width-1-2@s uk-child-width-1-1" uk-grid>
                <div class="isee-h4 uk-text-bold">
                  Nombre
                </div>
                <div class="">
                  {{ $product->name }}
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-child-width-1-2@s uk-child-width-1-1" uk-grid>
                <div class="isee-h4 uk-text-bold">
                  Código
                </div>
                <div class="">
                  {{ $product->code }}
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-child-width-1-2@s uk-child-width-1-1" uk-grid>
                <div class="isee-h4 uk-text-bold">
                  Descripción
                </div>
                <div class="">
                  {{ $product->description }}
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-child-width-1-2@s uk-child-width-1-1" uk-grid>
                <div class="isee-h4 uk-text-bold">
                  Imagen
                </div>
                <div class="">
                  <img src="{{ $product->image }}" alt="">
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-child-width-1-2@s uk-child-width-1-1" uk-grid>
                <div class="isee-h4 uk-text-bold">
                  Precio antiguo (tachado)
                </div>
                <div class="">
                  {{ $product->promo }}
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-child-width-1-2@s uk-child-width-1-1" uk-grid>
                <div class="isee-h4 uk-text-bold">
                  Precio de venta
                </div>
                <div class="">
                  {{ $product->price }}
                </div>
              </div>
            </div>
            <div class="uk-width-1-1">
              <div class="" uk-grid>
                <div class="uk-width-1-4@s uk-width-1-1">
                  <div class="isee-h4 uk-text-bold">
                    Categorías
                  </div>
                </div>
                <div class="uk-width-3-4@s uk-width-1-1">
                  <ul class="uk-list">
                    @foreach ($product->categories as $category)
                      <li>{{ $category->name }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            <div class="uk-width-1-1">
              <div class="" uk-grid>
                <div class="uk-width-1-4@s uk-width-1-1">
                  <div class="isee-h4 uk-text-bold">
                    Características
                  </div>
                </div>
                <div class="uk-width-3-4@s uk-width-1-1">
                  <div class="uk-child-width-1-4@s uk-child-width-1-1" uk-grid>
                    @foreach ($product->characteristics as $characteristic)
                      <div class="">
                        <strong>{{ $characteristic->name }}:</strong>
                        <span>
                          @foreach ($characteristic->attributes as $attribute)
                            <span>{{ $attribute->name }}</span>
                            @if ($loop->index !== count($characteristic->attributes)-1)
                              <span>-</span>
                            @endif
                          @endforeach
                        </span>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            <div class="uk-width-1-1">
              <div class="" uk-grid>
                <div class="uk-width-1-4@s uk-width-1-1">
                  <div class="isee-h4 uk-text-bold">
                    Tamaños
                  </div>
                </div>
                <div class="uk-width-3-4@s uk-width-1-1">
                  <div class="">
                    <table class="uk-table uk-table-striped">
                      <thead>
                        <tr>
                          <th>Tamaño</th>
                          <th>Puente</th>
                          <th>Ancho</th>
                          <th>Alto</th>
                          <th>Largo</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($product->sizes as $size)
                          <tr>
                            <td>{{ $size->name }}</td>
                            <td>{{ $size->bridge }}</td>
                            <td>{{ $size->width }}</td>
                            <td>{{ $size->height }}</td>
                            <td>{{ $size->large }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="uk-width-1-1">
              <div class="uk-form-controls uk-text-center">
                <a class="uk-button uk-button-large uk-button-primary" href="{{ route('products.index') }}">REGRESAR</a>
              </div>
            </div>
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
