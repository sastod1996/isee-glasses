@push('css')
<link rel="stylesheet" href="{{ mix('css/admin/pages/products.css') }}">
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
      @if (Session::has('products_warnings'))
        <div class="uk-alert uk-alert-warning" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <h3 class="uk-margin-small">Alerta</h3>
          @foreach (Session::get('products_warnings') as $key => $value)
            <h5 class="uk-margin-small">{{ $key }}</h5>
            <ul class="uk-margin-small">
              @foreach ($value as $warning)
                <li>{{ $warning }}</li>
              @endforeach
            </ul>
          @endforeach
        </div>
      @endif
      <div class="">
        <div class="uk-h2 uk-flex uk-flex-middle uk-flex-between">
          <div>
            Productos &nbsp;
            @if (Auth::user()->email !== 'diseno@isee-glasses.com')
              <a href="{{ route('products.create') }}" class="uk-button uk-background-primary uk-light">
                Nuevo Producto
              </a>
            @endif
          </div>
          @if (Auth::user()->email == 'develop@prodequa.com')
            <div>
              <a class="uk-button" href="{{ route('excel.orderfiles') }}">Copiar</a>
              @include('admin.products._import_products')
              @include('admin.products._import_stock')
            </div>
          @endif
        </div>
        <div class="uk-margin-medium">
          <form class="" action="/admin/search/products" method="get">
            <div class="" uk-grid>
              <div class="uk-width-1-5 uk-flex uk-flex-middle">
                <span>Buscar producto:</span>
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
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
            <thead>
              <tr>
                <th>#</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categorías</th>
                <th>Estado</th>
                @if (Auth::user()->email !== 'asistente@isee-glasses.com')
                  <th>Acciones</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @if (isset($newProducts))
                @foreach ($newProducts as $product)
                  <tr>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>S/. {{ $product->price }}</td>
                    <td>
                      @foreach ($product->categories as $category)
                        -{{ $category->name }}<br>
                      @endforeach
                    </td>
                    <td>
                      @if ($product->status == '1')
                        <span class="uk-text-bold uk-text-success">Activo</span>
                      @else
                        <span class="uk-text-bold uk-text-danger">Inactivo</span>
                      @endif
                    </td>
                    @if (Auth::user()->email == 'diseno@isee-glasses.com')
                      <td class="fit">
                        <a class="uk-button uk-button-default"
                          href="{{ route('products.edit', ['id' => $product->id]) }}">
                          Editar
                        </a>
                      </td>
                    @elseif (Auth::user()->email == 'asistente@isee-glasses.com')
                    @else
                      <td class="fit">
                        <a class="uk-button uk-button-default" href="{{ route('products.show', $product->slug) }}" target="_blank">Detalle</a>
                      </td>
                      <td class="fit">
                        <a class="uk-button uk-button-default"
                          href="{{ route('products.edit', ['id' => $product->id]) }}">
                          Editar
                        </a>
                      </td>
                      <td class="fit">
                        <a class="uk-width-small uk-button {{ $product->status == 1 ? 'uk-button-danger' : 'uk-button-secondary' }}"
                          href="{{ route('products.destroy', ['id' => $product->id]) }}"
                          data-method="delete"
                          data-confirm="¿{{ $product->status == 1 ? 'Desactivar' : 'Activar' }} el producto {{ $product->name }} - {{ $product->code }}?">
                          {{ $product->status == 1 ? 'Desactivar' : 'Activar' }}
                        </a>
                      </td>
                    @endif
                  </tr>
                @endforeach
              @else
                @foreach ($products as $index => $product)
                  <tr>
                    {{-- <td>{{ $loop->index+1 }}</td> --}}
                    <td>{{ $index + $products->firstItem() }}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>S/. {{ $product->price }}</td>
                    <td>
                      @foreach ($product->categories as $category)
                        -{{ $category->name }}<br>
                      @endforeach
                    </td>
                    <td>
                      @if ($product->status == '1')
                        <span class="uk-text-bold uk-text-success">Activo</span>
                      @else
                        <span class="uk-text-bold uk-text-danger">Inactivo</span>
                      @endif
                    </td>
                    @if (Auth::user()->email == 'diseno@isee-glasses.com')
                      <td class="fit">
                        <a class="uk-button uk-button-default"
                          href="{{ route('products.edit', ['id' => $product->id]) }}">
                          Editar
                        </a>
                      </td>
                    @elseif (Auth::user()->email == 'asistente@isee-glasses.com')

                    @else
                      <td class="fit">
                        <a class="uk-button uk-button-primary uk-light" href="#asign-{{ $product->slug }}" uk-toggle>Asignar</a>
                        @include('admin.products._modal_colorsizes', ['product' => $product])
                      </td>
                      <td class="fit">
                        <a class="uk-button uk-button-default" href="{{ route('products.show', $product->slug) }}" target="_blank">Detalle</a>
                      </td>
                      {{-- <td class="fit">
                        <a class="uk-button uk-button-secondary" href="{{ route('shop.show', $product->slug) }}" target="_blank">Ver</a>
                      </td> --}}
                      <td class="fit">
                        <a class="uk-button uk-button-default"
                          href="{{ route('products.edit', ['id' => $product->id]) }}">
                          Editar
                        </a>
                      </td>
                      <td class="fit">
                        <a class="uk-width-small uk-button {{ $product->status == 1 ? 'uk-button-danger' : 'uk-button-secondary' }}"
                          href="{{ route('products.destroy', ['id' => $product->id]) }}"
                          data-method="delete"
                          data-confirm="¿{{ $product->status == 1 ? 'Desactivar' : 'Activar' }} el producto {{ $product->name }} - {{ $product->code }}?">
                          {{ $product->status == 1 ? 'Desactivar' : 'Activar' }}
                        </a>
                      </td>
                    @endif
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
          @if (!isset($newProducts))
            <div class="">
              {{$products->render()}}
            </div>
          @endif
        </div>

        @if (Auth::user()->email == 'develop@prodequa.com')
          <div class="">
            @include('admin.products._refresh-random')
          </div>
        @endif
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
{{-- {{ $products->links() }} --}}
