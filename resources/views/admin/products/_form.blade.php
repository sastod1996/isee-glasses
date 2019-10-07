<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($product) ? route('products.update', ['id' => $product->id]) : route('products.store') }}" enctype="multipart/form-data" uk-grid>
  {{ csrf_field() }}

  @if (isset($product))
    <input type="hidden" name="_method" value="put">
    <input type="hidden" name="color_sizes_status" value="{{ $product->color_sizes_status}}">
    <input type="hidden" name="backTo" value="{{ isset($backTo) ? $backTo : ''}}">
  @endif

  @if (Auth::user()->email !== 'diseno@isee-glasses.com')
    {{-- @if (!isset($product)) --}}
      <div class="uk-width-1-1 uk-margin {{ $errors->has('code') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="code">Código</label>
        <div class="uk-form-controls">
          <input class="uk-input" id="code" name="code" type="text" value="{{ old('code', isset($product) ? $product->code : '') }}"
          @if (isset($product))
            readonly
          @endif
          >
          @if ($errors->has('code'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('code') }}</strong>
            </div>
          @endif
        </div>
      </div>
    {{-- @endif --}}

    <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('name') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="name">Nombre</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="name" name="name" type="text" value="{{ old('name', isset($product) ? $product->name : '') }}">
        @if ($errors->has('name'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('name') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('name_en') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="name_en">Nombre (Inglés)</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="name_en" name="name_en" type="text" value="{{ old('name_en', isset($product) ? $product->name_en : '') }}">
        @if ($errors->has('name_en'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('name_en') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('description') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="description">Descripción</label>
      <div class="uk-form-controls">
        <textarea class="uk-textarea" name="description" rows="3">{{ old('description', isset($product) ? $product->description : '') }}</textarea>
        @if ($errors->has('description'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('description') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('description_en') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="description_en">Descripción (Inglés)</label>
      <div class="uk-form-controls">
        <textarea class="uk-textarea" name="description_en" rows="3">{{ old('description_en', isset($product) ? $product->description_en : '') }}</textarea>
        @if ($errors->has('description_en'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('description_en') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <input type="hidden" name="qty" value="{{ rand(1, 1000) }}">

    <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('promo') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="promo">Precio antiguo (tachado)</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="promo" name="promo" type="number" value="{{ old('promo', isset($product) ? $product->promo : '') }}">
        @if ($errors->has('promo'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('promo') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('price') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="price">Precio de venta</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="price" name="price" type="number" value="{{ old('price', isset($product) ? $product->price : '') }}">
        @if ($errors->has('price'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('price') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="uk-width-1-1 uk-margin {{ $errors->has('image') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="image">Imagen por defecto</label>
      <div class="uk-form-controls">
        @if (isset($product))
          <div class="uk-width-1-3 isee-product-append">
            <div class="isee-product-div">
              <input class="uk-input" id="image" name="image" type="hidden" value="{{ $product->image }}">
              <div class="">
                <img class="" src="{{ $product->image }}" alt="">
              </div>
              <div class="">
                <a class="uk-button uk-button-default uk-width-1-1 isee-product-change">Cambiar de imagen</a>
              </div>
            </div>
          </div>
        @else
          <div class="uk-width-1-1 uk-inline" uk-form-custom>
            <input id="image" class="product-image" type="file" name="image">
            <a class="uk-form-icon uk-form-icon-flip isee-upload-image" href="#" uk-icon="icon: link" type="button" tabindex="-1"></a>
            <input class="uk-input product-filename" type="text">
          </div>
        @endif
        @if ($errors->has('image'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('image') }}</strong>
          </div>
        @endif
      </div>
    </div>

    @if (isset($product))
      <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('status') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="status">Estado</label>
        <div class="uk-form-controls">
          <div class="">
            <label>
              <input class="uk-radio" type="radio" name="status" value="1"
                @isset($product)
                  @if ($product->status == 1)
                    checked
                  @endif
                @endisset
              > Activo<br>
              <input class="uk-radio" type="radio" name="status" value="0"
              @isset($product)
                @if ($product->status == 0)
                  checked
                @endif
              @endisset
              > Inactivo
            </label>
          </div>
          @if ($errors->has('status'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('status') }}</strong>
            </div>
          @endif
        </div>
      </div>
    @else
      <input type="hidden" name="status" value="0">
      <input type="hidden" name="color_sizes_status" value="0">
    @endif

    {{-- <div id="select-characteristics" class="uk-width-1-1 uk-margin">
      <label class="uk-form-label" for="characteristics">Características</label>
      <div class="uk-form-controls">
        <div class="uk-background-muted">
          <div class="uk-padding">
            @foreach ($characteristics as $characteristic)
              <div class="uk-margin">
                <div class="uk-h4" style="font-weight: bolder; {{ $errors->has('chars.'.$characteristic->slug) ? ' color:#a94442' : '' }}">{{ $characteristic->name }}</div>
                @php
                $char = 'chars.'.$characteristic->slug;
                @endphp
                @if ($errors->has('chars.'.$characteristic->slug))
                  <p class="uk-text-danger" style="color:#a94442">
                    <strong>{{ $errors->first('chars.'.$characteristic->slug) }}</strong>
                  </p>
                @endif
                <div class="" uk-grid>
                  <ul class="uk-width-1-1 isee-characteristics-modal" uk-grid>
                    @foreach ($characteristic->attributes as $attribute)
                      @if ($characteristic->slug == 'color')
                        <li class="uk-width-1-3@m uk-width-1-1">
                      @else
                        <li class="uk-width-1-5@m uk-width-1-1">
                      @endif
                        <label>
                          <input class="attribute" type="{{$characteristic->multiple ? 'checkbox' : 'radio'}}" characteristic="{{$characteristic->slug}}" name="chars[{{$characteristic->slug}}][]" value="{{ $attribute->id }}"
                          @if (isset($product))
                            @foreach ($product->attributes as $attr)
                              @if ($attribute->id == $attr->id)
                                checked
                              @endif
                            @endforeach
                          @endif
                          > {{ $attribute->name }}
                          @if ($characteristic->slug == 'color')
                            <div id="input-files{{$attribute->id}}" style="display:none;">
                              @for ($i=0; $i < 3; $i++)
                                <div class="">
                                  <label for="imgColor{{$attribute->id}}">
                                    Imagen {{$i+1}}
                                    <input name="imgColor[{{$attribute->slug}}][]" type="file" class="" id="imgColor{{$attribute->id}}">
                                  </label>
                                </div>
                              @endfor
                              <div class="">
                                <label for="camera{{$attribute->id}}">Probador</label>
                                <div class="">
                                  <input name="camera[{{$attribute->slug}}]" type="file" class="" id="camera{{$attribute->id}}">
                                </div>
                              </div>
                            </div>
                          @elseif ($characteristic->slug == 'tamanio')
                            <div id="input-sizes{{ $attribute->id }}" style="display:none;" uk-grid>
                              <div class="uk-width-1-1@s uk-width-1-2">
                                <label>
                                  Puente
                                  <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][bridge]" value="0">
                                </label>
                              </div>
                              <div class="uk-width-1-1@s uk-width-1-2">
                                <label>
                                  Ancho
                                  <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][width]" value="0">
                                </label>
                              </div>
                              <div class="uk-width-1-1@s uk-width-1-2">
                                <label>
                                  Alto
                                  <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][height]" value="0">
                                </label>
                              </div>
                              <div class="uk-width-1-1@s uk-width-1-2">
                                <label>
                                  Largo
                                  <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][large]" value="0">
                                </label>
                              </div>
                            </div>
                          @endif
                        </label>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        @if ($errors->has('attrs'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('attrs') }}</strong>
          </div>
        @endif
      </div>
    </div> --}}

    <div id="select-characteristics" class="uk-width-1-1 uk-margin">
      <label class="uk-form-label" for="characteristics">Características</label>
      <div class="uk-form-controls">
        <div class="uk-background-muted">
          <div class="uk-padding">
            @foreach ($characteristics as $characteristic)
              <div class="uk-margin">
                @if (!isset($product))
                  <div class="uk-h4" style="font-weight: bolder; {{ $errors->has('chars.'.$characteristic->slug) ? ' color:#a94442' : '' }}">{{ $characteristic->name }}</div>
                @elseif ( $characteristic->slug == 'color')
                  <div class="uk-h4" style="font-weight: bolder; {{ $errors->has('chars.'.$characteristic->slug) ? ' color:#a94442' : '' }}"> Modificar imágenes según color </div>
                @elseif ( $characteristic->slug == 'tamanio')
                  <div class="uk-h4" style="font-weight: bolder; {{ $errors->has('chars.'.$characteristic->slug) ? ' color:#a94442' : '' }}"> Modificar tamaños </div>
                @endif
                @php
                $char = 'chars.'.$characteristic->slug;
                @endphp
                @if ($errors->has('chars.'.$characteristic->slug))
                  <p class="uk-text-danger" style="color:#a94442">
                    <strong>{{ $errors->first('chars.'.$characteristic->slug) }}</strong>
                  </p>
                @endif
                <div class="">
                  @if ($characteristic->slug == 'color')
                    <div class="uk-margin-small">
                      <label class="uk-form-label" for="">Elegir color</label>
                      <div class="uk-form-controls">
                        <select class="uk-select isee-color-selected">
                          <option value="" selected disabled>Seleccionar color</option>
                          @if (!isset($product))
                            @foreach ($characteristic->attributes as $attribute)
                              <option value="{{ $attribute->id }}" data-labcolor="" data-slug="{{ $attribute->slug }}">{{ $attribute->name }}</option>
                            @endforeach
                          @else
                            @foreach ($product->attributes as $attribute)
                              @if ($attribute->characteristic_id == 6 ) {{-- Si el atributo es color --}}
                                <option value="{{ $attribute->id }}" data-labcolor="{{ $attribute->pivot->lab_codecolor }}" data-slug="{{ $attribute->slug }}">{{ $attribute->name }}</option>
                              @endif
                            @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="uk-margin isee-color-append">
                      <div class="uk-margin-small isee-color-headers uk-hidden" uk-grid>
                        <div class="uk-width-1-4">
                          <div class="" uk-grid>
                            <div class="uk-width-1-2">
                              COLOR
                            </div>
                            <div class="uk-width-1-2">
                              CÓDIGO
                            </div>
                          </div>
                        </div>
                        <div class="uk-width-3-4">
                          <div class="" uk-grid>
                            <div class="uk-width-1-5">
                              IMAGEN 1
                            </div>
                            <div class="uk-width-1-5">
                              IMAGEN 2
                            </div>
                            <div class="uk-width-1-5">
                              IMAGEN 3
                            </div>
                            <div class="uk-width-1-5">
                              CÁMARA 1
                            </div>
                            <div class="uk-width-1-5">
                              ¿ELIMINAR?
                            </div>
                          </div>
                        </div>
                      </div>
                      {{-- <div class="uk-margin-small isee-color-body" uk-grid>
                        <div class="uk-width-1-4">
                          <div class="" uk-grid>
                            <input type="hidden" name="chars[{{ $characteristic->slug }}][id][]" characteristic="{{ $characteristic->slug }}" value="{{ $attribute->id }}">
                            <div class="uk-width-1-2">
                              <input class="uk-input" type="text" value="{{ $attribute->name }}" disabled>
                            </div>
                            <div class="uk-width-1-2">
                              <input class="uk-input" type="text" name="chars[{{ $characteristic->slug }}][code][]" value="" placeholder="Código">
                            </div>
                          </div>
                        </div>
                        <div class="uk-width-3-4">
                          <div class="" uk-grid>
                            <div class="uk-width-1-5">
                              <div uk-form-custom="target: true">
                                <input type="file" name="imgColor[{{$attribute->slug}}][]">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>
                              </div>
                            </div>
                            <div class="uk-width-1-5">
                              <div uk-form-custom="target: true">
                                <input type="file" name="imgColor[{{$attribute->slug}}][]">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>
                              </div>
                            </div>
                            <div class="uk-width-1-5">
                              <div uk-form-custom="target: true">
                                <input type="file" name="imgColor[{{$attribute->slug}}][]">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>
                              </div>
                            </div>
                            <div class="uk-width-1-5">
                              <div uk-form-custom="target: true">
                                <input type="file" name="camera[{{$attribute->slug}}][]">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>
                              </div>
                            </div>
                            <div class="uk-width-1-5">
                              <a href="#" class="" uk-icon="icon: trash"></a>
                            </div>
                          </div>
                        </div>
                      </div> --}}
                    </div>
                  @elseif ($characteristic->slug == 'tamanio')
                    @if (isset($product))
                      <table class="uk-table uk-table-divider uk-width-2-3 uk-margin-auto">
                        <thead>
                          <tr>
                            <td></td>
                            <td>Puente</td>
                            <td>Ancho</td>
                            <td>Alto</td>
                            <td>Largo</td>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($characteristic->attributes as $attribute)
                            @if ($attribute->characteristic_id == 2)
                              @foreach ($product->attributes as $attr)
                                @if ($attr->characteristic_id == 2)
                                  @if ($attr->id == $attribute->id)
                                    <tr>
                                      <td>{{ $attribute->name }}</td>
                                      <input type="hidden" name="attr_slugs[]" value="{{ $attribute->slug }}">
                                      <input type="hidden" name="attr_prod_id" value="{{ $attr->pivot->id }}">
                                      <td>
                                        <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][bridge]" value="{{ $attr->pivot->bridge }}">
                                      </td>
                                      <td>
                                        <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][width]" value="{{ $attr->pivot->width }}">
                                      </td>
                                      <td>
                                        <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][height]" value="{{ $attr->pivot->height }}">
                                      </td>
                                      <td>
                                        <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][large]" value="{{ $attr->pivot->large }}">
                                      </td>
                                    </tr>
                                  @endif
                                @endif
                              @endforeach
                            @endif
                          @endforeach
                        </tbody>
                      </table>
                    @else
                      <ul class="isee-characteristics-modal" uk-grid>
                        @foreach ($characteristic->attributes as $attribute)
                          <li class="uk-width-1-5@m uk-width-1-1">
                            <label>
                              <input class="attribute" type="{{$characteristic->multiple ? 'checkbox' : 'radio'}}" characteristic="{{$characteristic->slug}}" name="chars[{{$characteristic->slug}}][]" value="{{ $attribute->id }}"> {{ $attribute->name }}
                              @if ($characteristic->slug == 'tamanio')
                                <div id="input-sizes{{ $attribute->id }}" style="display:none;" uk-grid>
                                  <div class="uk-width-1-1@s uk-width-1-2">
                                    <label>
                                      Puente
                                      <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][bridge]" value="0">
                                    </label>
                                  </div>
                                  <div class="uk-width-1-1@s uk-width-1-2">
                                    <label>
                                      Ancho
                                      <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][width]" value="0">
                                    </label>
                                  </div>
                                  <div class="uk-width-1-1@s uk-width-1-2">
                                    <label>
                                      Alto
                                      <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][height]" value="0">
                                    </label>
                                  </div>
                                  <div class="uk-width-1-1@s uk-width-1-2">
                                    <label>
                                      Largo
                                      <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][large]" value="0">
                                    </label>
                                  </div>
                                </div>
                              @endif
                            </label>
                          </li>
                        @endforeach
                      </ul>
                    @endif

                    {{-- <div id="input-sizes{{ $attribute->id }}" uk-grid>
                      <div class="uk-width-1-1@s uk-width-1-2">
                        <label>
                          Puente
                          <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][bridge]" value="0">
                        </label>
                      </div>
                      <div class="uk-width-1-1@s uk-width-1-2">
                        <label>
                          Ancho
                          <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][width]" value="0">
                        </label>
                      </div>
                      <div class="uk-width-1-1@s uk-width-1-2">
                        <label>
                          Alto
                          <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][height]" value="0">
                        </label>
                      </div>
                      <div class="uk-width-1-1@s uk-width-1-2">
                        <label>
                          Largo
                          <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][large]" value="0">
                        </label>
                      </div>
                    </div> --}}
                  @elseif (!isset($product))
                    <ul class="isee-characteristics-modal" uk-grid>
                      @foreach ($characteristic->attributes as $attribute)
                        <li class="uk-width-1-5@m uk-width-1-1">
                          <label>
                            <input class="attribute" type="{{$characteristic->multiple ? 'checkbox' : 'radio'}}" characteristic="{{$characteristic->slug}}" name="chars[{{$characteristic->slug}}][]" value="{{ $attribute->id }}"
                            @if (isset($product))
                              @foreach ($product->attributes as $attr)
                                @if ($attribute->id == $attr->id)
                                  checked
                                @endif
                              @endforeach
                            @endif
                            > {{ $attribute->name }}
                          </label>
                        </li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
        @if ($errors->has('attrs'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('attrs') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="uk-width-1-1 uk-margin">
      <label class="uk-form-label" for="categories">Categorías</label>
      <div class="uk-form-controls">
        @foreach ($categories as $category)
          <label>
            <input class="uk-checkbox" type="checkbox" name="categories[]" value="{{ $category->id }}"
            @if (isset($product))
              @foreach ($product->categories as $cat)
                @if ($cat->id == $category->id)
                  checked
                @endif
              @endforeach
            @endif
            > {{ $category->name }}
          </label><br>
        @endforeach
        @if ($errors->has('categories'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('categories') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="uk-width-1-1 uk-margin">
      <div class="uk-form-controls">
        <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
        <a class="uk-button uk-button-default" href="{{ isset($backTo) ? url($backTo) : route('products.index') }}">REGRESAR</a>
      </div>
    </div>
  @else
    {{-- Ocultar a diseno@isee-glasses.com --}}
    <div class="uk-hidden">
      {{-- @if (!isset($product)) --}}
        <div class="uk-width-1-1 uk-margin {{ $errors->has('code') ? 'has-error' : '' }}">
          <label class="uk-form-label" for="code">Código</label>
          <div class="uk-form-controls">
            <input class="uk-input" id="code" name="code" type="text" value="{{ old('code', isset($product) ? $product->code : '') }}"
            @if (isset($product))
              readonly
            @endif
            >
            @if ($errors->has('code'))
              <div class="uk-text-danger">
                <strong>{{ $errors->first('code') }}</strong>
              </div>
            @endif
          </div>
        </div>
      {{-- @endif --}}

      <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('name') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="name">Nombre</label>
        <div class="uk-form-controls">
          <input class="uk-input" id="name" name="name" type="text" value="{{ old('name', isset($product) ? $product->name : '') }}">
          @if ($errors->has('name'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('name') }}</strong>
            </div>
          @endif
        </div>
      </div>

      <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('name_en') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="name_en">Nombre (Inglés)</label>
        <div class="uk-form-controls">
          <input class="uk-input" id="name_en" name="name_en" type="text" value="{{ old('name_en', isset($product) ? $product->name_en : '') }}">
          @if ($errors->has('name_en'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('name_en') }}</strong>
            </div>
          @endif
        </div>
      </div>

      <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('description') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="description">Descripción</label>
        <div class="uk-form-controls">
          <textarea class="uk-textarea" name="description" rows="3">{{ old('description', isset($product) ? $product->description : '') }}</textarea>
          @if ($errors->has('description'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('description') }}</strong>
            </div>
          @endif
        </div>
      </div>

      <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('description_en') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="description_en">Descripción (Inglés)</label>
        <div class="uk-form-controls">
          <textarea class="uk-textarea" name="description_en" rows="3">{{ old('description_en', isset($product) ? $product->description_en : '') }}</textarea>
          @if ($errors->has('description_en'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('description_en') }}</strong>
            </div>
          @endif
        </div>
      </div>

      <input type="hidden" name="qty" value="{{ rand(1, 1000) }}">

      <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('promo') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="promo">Precio antiguo (tachado)</label>
        <div class="uk-form-controls">
          <input class="uk-input" id="promo" name="promo" type="number" value="{{ old('promo', isset($product) ? $product->promo : '') }}">
          @if ($errors->has('promo'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('promo') }}</strong>
            </div>
          @endif
        </div>
      </div>

      <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('price') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="price">Precio de venta</label>
        <div class="uk-form-controls">
          <input class="uk-input" id="price" name="price" type="number" value="{{ old('price', isset($product) ? $product->price : '') }}">
          @if ($errors->has('price'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('price') }}</strong>
            </div>
          @endif
        </div>
      </div>

      @if (isset($product))
        <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('status') ? 'has-error' : '' }}">
          <label class="uk-form-label" for="status">Estado</label>
          <div class="uk-form-controls">
            <div class="">
              <label>
                <input class="uk-radio" type="radio" name="status" value="1"
                  @isset($product)
                    @if ($product->status == 1)
                      checked
                    @endif
                  @endisset
                > Activo<br>
                <input class="uk-radio" type="radio" name="status" value="0"
                @isset($product)
                  @if ($product->status == 0)
                    checked
                  @endif
                @endisset
                > Inactivo
              </label>
            </div>
            @if ($errors->has('status'))
              <div class="uk-text-danger">
                <strong>{{ $errors->first('status') }}</strong>
              </div>
            @endif
          </div>
        </div>
      @else
        <input type="hidden" name="status" value="0">
        <input type="hidden" name="color_sizes_status" value="0">
      @endif

      <div class="uk-width-1-1 uk-margin">
        <label class="uk-form-label" for="categories">Categorías</label>
        <div class="uk-form-controls">
          @foreach ($categories as $category)
            <label>
              <input class="uk-checkbox" type="checkbox" name="categories[]" value="{{ $category->id }}"
              @if (isset($product))
                @foreach ($product->categories as $cat)
                  @if ($cat->id == $category->id)
                    checked
                  @endif
                @endforeach
              @endif
              > {{ $category->name }}
            </label><br>
          @endforeach
          @if ($errors->has('categories'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('categories') }}</strong>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="uk-width-1-1 uk-margin {{ $errors->has('image') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="image">Imagen por defecto</label>
      <div class="uk-form-controls">
        @if (isset($product))
          <div class="uk-width-1-3 isee-product-append">
            <div class="isee-product-div">
              <input class="uk-input" id="image" name="image" type="hidden" value="{{ $product->image }}">
              <div class="">
                <img class="" src="{{ $product->image }}" alt="">
              </div>
              <div class="">
                <a class="uk-button uk-button-default uk-width-1-1 isee-product-change">Cambiar de imagen</a>
              </div>
            </div>
          </div>
        @else
          <div class="uk-width-1-1 uk-inline" uk-form-custom>
            <input id="image" class="product-image" type="file" name="image">
            <a class="uk-form-icon uk-form-icon-flip isee-upload-image" href="#" uk-icon="icon: link" type="button" tabindex="-1"></a>
            <input class="uk-input product-filename" type="text">
          </div>
        @endif
        @if ($errors->has('image'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('image') }}</strong>
          </div>
        @endif
      </div>
    </div>



    <div id="select-characteristics" class="uk-width-1-1 uk-margin">
      <label class="uk-form-label" for="characteristics">Características</label>
      <div class="uk-form-controls">
        <div class="uk-background-muted">
          <div class="uk-padding">
            @foreach ($characteristics as $characteristic)
              <div class="uk-margin">
                @if (!isset($product))
                  <div class="uk-h4" style="font-weight: bolder; {{ $errors->has('chars.'.$characteristic->slug) ? ' color:#a94442' : '' }}">{{ $characteristic->name }}</div>
                @elseif ( $characteristic->slug == 'color')
                  <div class="uk-h4" style="font-weight: bolder; {{ $errors->has('chars.'.$characteristic->slug) ? ' color:#a94442' : '' }}"> Modificar imágenes según color </div>
                @elseif ( $characteristic->slug == 'tamanio')
                  <div class="uk-h4" style="font-weight: bolder; {{ $errors->has('chars.'.$characteristic->slug) ? ' color:#a94442' : '' }}"> Modificar tamaños </div>
                @endif
                @php
                $char = 'chars.'.$characteristic->slug;
                @endphp
                @if ($errors->has('chars.'.$characteristic->slug))
                  <p class="uk-text-danger" style="color:#a94442">
                    <strong>{{ $errors->first('chars.'.$characteristic->slug) }}</strong>
                  </p>
                @endif
                <div class="">
                  @if ($characteristic->slug == 'color')
                    <div class="uk-margin-small">
                      <label class="uk-form-label" for="">Elegir color</label>
                      <div class="uk-form-controls">
                        <select class="uk-select isee-color-selected">
                          <option value="" selected disabled>Seleccionar color</option>
                          @if (!isset($product))
                            @foreach ($characteristic->attributes as $attribute)
                              <option value="{{ $attribute->id }}" data-labcolor="" data-slug="{{ $attribute->slug }}">{{ $attribute->name }}</option>
                            @endforeach
                          @else
                            @foreach ($product->attributes as $attribute)
                              @if ($attribute->characteristic_id == 6 ) {{-- Si el atributo es color --}}
                                <option value="{{ $attribute->id }}" data-labcolor="{{ $attribute->pivot->lab_codecolor }}" data-slug="{{ $attribute->slug }}">{{ $attribute->name }}</option>
                              @endif
                            @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="uk-margin isee-color-append">
                      <div class="uk-margin-small isee-color-headers uk-hidden" uk-grid>
                        <div class="uk-width-1-4">
                          <div class="" uk-grid>
                            <div class="uk-width-1-2">
                              COLOR
                            </div>
                            <div class="uk-width-1-2">
                              CÓDIGO
                            </div>
                          </div>
                        </div>
                        <div class="uk-width-3-4">
                          <div class="" uk-grid>
                            <div class="uk-width-1-5">
                              IMAGEN 1
                            </div>
                            <div class="uk-width-1-5">
                              IMAGEN 2
                            </div>
                            <div class="uk-width-1-5">
                              IMAGEN 3
                            </div>
                            <div class="uk-width-1-5">
                              CÁMARA 1
                            </div>
                            <div class="uk-width-1-5">
                              ¿ELIMINAR?
                            </div>
                          </div>
                        </div>
                      </div>
                      {{-- <div class="uk-margin-small isee-color-body" uk-grid>
                        <div class="uk-width-1-4">
                          <div class="" uk-grid>
                            <input type="hidden" name="chars[{{ $characteristic->slug }}][id][]" characteristic="{{ $characteristic->slug }}" value="{{ $attribute->id }}">
                            <div class="uk-width-1-2">
                              <input class="uk-input" type="text" value="{{ $attribute->name }}" disabled>
                            </div>
                            <div class="uk-width-1-2">
                              <input class="uk-input" type="text" name="chars[{{ $characteristic->slug }}][code][]" value="" placeholder="Código">
                            </div>
                          </div>
                        </div>
                        <div class="uk-width-3-4">
                          <div class="" uk-grid>
                            <div class="uk-width-1-5">
                              <div uk-form-custom="target: true">
                                <input type="file" name="imgColor[{{$attribute->slug}}][]">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>
                              </div>
                            </div>
                            <div class="uk-width-1-5">
                              <div uk-form-custom="target: true">
                                <input type="file" name="imgColor[{{$attribute->slug}}][]">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>
                              </div>
                            </div>
                            <div class="uk-width-1-5">
                              <div uk-form-custom="target: true">
                                <input type="file" name="imgColor[{{$attribute->slug}}][]">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>
                              </div>
                            </div>
                            <div class="uk-width-1-5">
                              <div uk-form-custom="target: true">
                                <input type="file" name="camera[{{$attribute->slug}}][]">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>
                              </div>
                            </div>
                            <div class="uk-width-1-5">
                              <a href="#" class="" uk-icon="icon: trash"></a>
                            </div>
                          </div>
                        </div>
                      </div> --}}
                    </div>
                  @elseif ($characteristic->slug == 'tamanio')
                    @if (isset($product))
                      <table class="uk-table uk-table-divider uk-width-2-3 uk-margin-auto">
                        <thead>
                          <tr>
                            <td></td>
                            <td>Puente</td>
                            <td>Ancho</td>
                            <td>Alto</td>
                            <td>Largo</td>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($characteristic->attributes as $attribute)
                            @if ($attribute->characteristic_id == 2)
                              @foreach ($product->attributes as $attr)
                                @if ($attr->characteristic_id == 2)
                                  @if ($attr->id == $attribute->id)
                                    <tr>
                                      <td>{{ $attribute->name }}</td>
                                      <input type="hidden" name="attr_slugs[]" value="{{ $attribute->slug }}">
                                      <input type="hidden" name="attr_prod_id" value="{{ $attr->pivot->id }}">
                                      <td>
                                        <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][bridge]" value="{{ $attr->pivot->bridge }}">
                                      </td>
                                      <td>
                                        <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][width]" value="{{ $attr->pivot->width }}">
                                      </td>
                                      <td>
                                        <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][height]" value="{{ $attr->pivot->height }}">
                                      </td>
                                      <td>
                                        <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][large]" value="{{ $attr->pivot->large }}">
                                      </td>
                                    </tr>
                                  @endif
                                @endif
                              @endforeach
                            @endif
                          @endforeach
                        </tbody>
                      </table>
                    @else
                      <ul class="isee-characteristics-modal" uk-grid>
                        @foreach ($characteristic->attributes as $attribute)
                          <li class="uk-width-1-5@m uk-width-1-1">
                            <label>
                              <input class="attribute" type="{{$characteristic->multiple ? 'checkbox' : 'radio'}}" characteristic="{{$characteristic->slug}}" name="chars[{{$characteristic->slug}}][]" value="{{ $attribute->id }}"> {{ $attribute->name }}
                              @if ($characteristic->slug == 'tamanio')
                                <div id="input-sizes{{ $attribute->id }}" style="display:none;" uk-grid>
                                  <div class="uk-width-1-1@s uk-width-1-2">
                                    <label>
                                      Puente
                                      <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][bridge]" value="0">
                                    </label>
                                  </div>
                                  <div class="uk-width-1-1@s uk-width-1-2">
                                    <label>
                                      Ancho
                                      <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][width]" value="0">
                                    </label>
                                  </div>
                                  <div class="uk-width-1-1@s uk-width-1-2">
                                    <label>
                                      Alto
                                      <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][height]" value="0">
                                    </label>
                                  </div>
                                  <div class="uk-width-1-1@s uk-width-1-2">
                                    <label>
                                      Largo
                                      <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][large]" value="0">
                                    </label>
                                  </div>
                                </div>
                              @endif
                            </label>
                          </li>
                        @endforeach
                      </ul>
                    @endif

                    {{-- <div id="input-sizes{{ $attribute->id }}" uk-grid>
                      <div class="uk-width-1-1@s uk-width-1-2">
                        <label>
                          Puente
                          <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][bridge]" value="0">
                        </label>
                      </div>
                      <div class="uk-width-1-1@s uk-width-1-2">
                        <label>
                          Ancho
                          <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][width]" value="0">
                        </label>
                      </div>
                      <div class="uk-width-1-1@s uk-width-1-2">
                        <label>
                          Alto
                          <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][height]" value="0">
                        </label>
                      </div>
                      <div class="uk-width-1-1@s uk-width-1-2">
                        <label>
                          Largo
                          <input class="uk-input" type="number" name="tamanios[{{ $attribute->slug }}][large]" value="0">
                        </label>
                      </div>
                    </div> --}}
                  @elseif (!isset($product))
                    <ul class="isee-characteristics-modal" uk-grid>
                      @foreach ($characteristic->attributes as $attribute)
                        <li class="uk-width-1-5@m uk-width-1-1">
                          <label>
                            <input class="attribute" type="{{$characteristic->multiple ? 'checkbox' : 'radio'}}" characteristic="{{$characteristic->slug}}" name="chars[{{$characteristic->slug}}][]" value="{{ $attribute->id }}"
                            @if (isset($product))
                              @foreach ($product->attributes as $attr)
                                @if ($attribute->id == $attr->id)
                                  checked
                                @endif
                              @endforeach
                            @endif
                            > {{ $attribute->name }}
                          </label>
                        </li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
        @if ($errors->has('attrs'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('attrs') }}</strong>
          </div>
        @endif
      </div>
    </div>
    <div class="uk-width-1-1 uk-margin">
      <div class="uk-form-controls">
        <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
        <a class="uk-button uk-button-default" href="{{ isset($backTo) ? url($backTo) : route('products.index') }}">REGRESAR</a>
      </div>
    </div>
  @endif

</form>

@push('js')
  <script>
    $('.isee-product-change').click(function(){
      $('.isee-product-append').append("\
      <div uk-form-custom='target: true'>\
        <input type='file' name='image' accept='image/*'> \
        <input class='uk-input uk-form-width-large' type='text' placeholder='Seleccionar imagen' disabled>\
      </div>\
      ");
      $('.isee-product-div').remove()
    });

    $('.attribute').on('click', function(){
      var attribute_id = $(this).val()
      var characteristic = $(this).attr('characteristic');
      if ($(this).is(':checked')) {
        if (characteristic == 'color') {
          var files = $('#input-files'+attribute_id)
          files.show()
        }else if (characteristic == 'tamanio') {
          var sizes = $('#input-sizes'+attribute_id)
          sizes.show()
        }
      }else {
        if (characteristic == 'color') {
          var files = $('#input-files'+attribute_id)
          files.hide()
        } else if (characteristic == 'tamanio') {
          var sizes = $('#input-sizes'+attribute_id)
          sizes.hide()
        }
      }
    });
  </script>

  <script>
    $('.product-image').change(function(){
      var filename = $(this).val()
      filename = filename.split(/(\\|\/)/g).pop()
      $('.product-filename').val(filename)
    });
  </script>

  <script>
    $('.isee-color-selected').change(function(){
      var el = $(this).find('option:selected')
      var id = el.val()
      var name = el.html()
      var slug = el.data('slug')
      var lab_codecolor = el.data('labcolor')
      $('.isee-color-headers').removeClass('uk-hidden')
      var contenido = '\
      <div class="uk-margin-small isee-color-body isee-color-div-'+ id +'" uk-grid>\
        <div class="uk-width-1-4">\
          <div class="" uk-grid>\
            <input type="hidden" name="chars[color][]" characteristic="color" value="'+ id +'">\
            <div class="uk-width-1-2">\
              <input class="uk-input" type="text" value="'+ name +'" disabled>\
            </div>\
            <div class="uk-width-1-2">\
            <input class="uk-input" type="text" name="codes[]" value="'+lab_codecolor+'" placeholder="Código">\
            </div>\
          </div>\
        </div>\
        <div class="uk-width-3-4">\
          <div class="" uk-grid>\
            <div class="uk-width-1-5">\
              <div uk-form-custom="target: true">\
                <input type="file" name="imgColor['+ slug +'][]" required>\
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>\
              </div>\
            </div>\
            <div class="uk-width-1-5">\
              <div uk-form-custom="target: true">\
                <input type="file" name="imgColor['+ slug +'][]" required>\
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>\
              </div>\
            </div>\
            <div class="uk-width-1-5">\
              <div uk-form-custom="target: true">\
                <input type="file" name="imgColor['+ slug +'][]" required>\
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>\
              </div>\
            </div>\
            <div class="uk-width-1-5">\
              <div uk-form-custom="target: true">\
                <input type="file" name="camera['+ slug +'][]" required>\
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Subir archivo" disabled>\
              </div>\
            </div>\
            <div class="uk-width-1-5">\
              <a class="" uk-icon="icon: trash" onclick="deleteColor('+ id +')"></a>\
            </div>\
          </div>\
        </div>\
      </div>\
      ';
      $('.isee-color-append').append(contenido)
    });

    function deleteColor(id){
      $('.isee-color-div-'+id).remove()
    }
  </script>
@endpush
