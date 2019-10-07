@push('css')
<link rel="stylesheet" href="{{ mix('css/site/pages/home.css') }}">
@endpush

@push('js')
<script>window.PromoContainer =  {!! json_encode($promotions) !!};</script>
<script src="{{ mix('js/site/home.js') }}"></script>
@endpush

@extends('layouts.site')

@section('content')

  {{-- MODAL --}}
  @if (isset($status))
    @if (isset($popup) && $status)
      <div class="uk-hidden uk-width-1-1" id="mobileModalBottom" style="position: fixed; bottom: 0; background-color: black; opacity: 0.8; z-index: 999;">
        <div class="uk-flex uk-flex-middle uk-height-1-1">
          <div class="uk-padding-small uk-width-1-1 uk-grid-collapse" uk-grid>
            <div class="uk-width-2-3 uk-flex uk-flex">
              <div class="uk-width-1-5">
                <img src="/pages/play-button.png" alt="">
              </div>
              <div class="uk-width-4-5 uk-text-left">
                <a id="openModalTop" class="uk-text-bold uk-text-uppercase uk-light" href="#">Para ver el cupón</a>
              </div>
            </div>
            <div class="uk-width-1-3">
              <div class="uk-text-right">
                <a id="closeModalBottom" href="#" uk-close></a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-hidden@s uk-width-1-1" id="mobileModalTop" style="position: fixed; bottom: 0; background-color: black; opacity: 0.9; z-index: 999;">
        <div class="uk-flex uk-flex-middle uk-height-1-1">
          <div class="uk-width-1-1">
            <div class="uk-text-center">
              <a id="closeModalTop" class="uk-modal-close uk-position-right uk-padding-small" uk-close style="padding: 10px 15px 0px 15px;"></a>
              <div class="" style="padding: 30px 15px 10px 15px;">
                <div class="uk-padding-small uk-padding-remove-bottom" style="border: 4px solid white;">
                  <div class="uk-h1 uk-margin-remove uk-padding-remove uk-text-bold uk-text-uppercase uk-light">
                    {{ $popup->title }}
                  </div>
                  <div class="uk-light uk-margin-xsmall">
                    <span class="uk-h2 uk-text-bold  uk-padding-remove">{{ $popup->coupon->percent }}% DSCTO.</span>
                  </div>
                  <div class="uk-h6 uk-margin-remove uk-text-bold uk-light uk-text-center">
                    {{ $popup->text_main }}
                  </div>
                  <div class="uk-h6 uk-margin-remove uk-light">
                    * {{ $popup->text_secondary }}
                  </div>
                  <div class="uk-margin-small">
                    <form class="" action="{{ route('interesados.store') }}" method="post">
                      {{ csrf_field() }}
                      <input type="hidden" name="popup_id" value="{{ $popup->id }}">
                      <div class="">
                        <input class="uk-input uk-form-small" type="text" name="name" placeholder="Nombres">
                      </div>
                      <div class="uk-margin-small">
                        <div class="uk-flex">
                          <div class="uk-width-1-4">
                            <select class="uk-select uk-form-small" name="tele">
                              @for ($i=00; $i < 1000; $i++)
                                <option value="+{{ $i }}"
                                  @if ($i == 51)
                                    selected
                                  @endif
                                >+
                                @if ($i<10)
                                  0{{ $i }}
                                @else
                                  {{ $i }}
                                @endif
                              </option>
                              @endfor
                            </select>
                          </div>
                          <div class="uk-width-expand">
                            <input class="uk-input uk-form-small" type="text" name="phone" minlength="9" placeholder="Celular">
                          </div>
                        </div>
                      </div>
                      <div class="uk-margin-small">
                        <input class="uk-input uk-form-small" type="email" name="email" placeholder="Correo">
                      </div>
                      <div class="uk-margin uk-text-center">
                        <button class="uk-button uk-button-small isee-background-green uk-light uk-text-bold" type="submit">Enviarme cupón</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="">
        <div id="modal-center" class="uk-flex-top uk-visible@s" uk-modal>
          <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-background-cover isee-modal-dialog" style="padding: 20px 0px 0px 0px; background-image: url({{ isset($popup->image) ? $popup->image : 'https://via.placeholder.com/900x560/003d5d' }});">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="">
              <div class="">
                <div class="uk-child-width-1-2 uk-grid-collapse" uk-grid>
                  <div class="uk-visible">

                  </div>
                  <div class="uk-padding-small">
                    <div class="uk-margin uk-padding-small" style="border: 3px solid white;">
                      <div class="isee-h1 uk-margin-remove uk-light uk-text-uppercase uk-text-bold uk-text-center">{{ $popup->title }}</div>
                      <div class="uk-text-center uk-light">
                        <span class="uk-text-bold isee-modal-title">{{ $popup->coupon->percent }}%</span>
                        <span class="isee-h1 uk-text-bold"> DSCTO.</span>
                      </div>
                    </div>
                    <div class="uk-margin uk-margin-remove-bottom">
                      <div class="uk-h5 uk-margin-remove-bottom uk-text-bold uk-light uk-text-center">{{ $popup->text_main }}</div>
                      <div class="uk-h6 uk-margin-small uk-light">* {{ $popup->text_secondary }}</div>
                    </div>
                    <div class="uk-margin">
                      <form class="" action="{{ route('interesados.store') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="popup_id" value="{{ $popup->id }}">
                        <div class="uk-margin">
                          <input class="uk-input uk-form-small" type="text" name="name" placeholder="Nombres" required>
                        </div>
                        <div class="uk-margin">
                          <div class="uk-flex">
                            <div class="uk-width-1-4">
                              <select class="uk-select uk-form-small" name="tele" required>
                                @for ($i=00; $i < 1000; $i++)
                                  <option value="+{{ $i }}"
                                    @if ($i == 51)
                                      selected
                                    @endif
                                  >+
                                  @if ($i<10)
                                    0{{ $i }}
                                  @else
                                    {{ $i }}
                                  @endif
                                </option>
                                @endfor
                              </select>
                            </div>
                            <div class="uk-width-expand">
                              <input class="uk-input uk-form-small" type="number" name="phone" min="900000000" max="999999999" placeholder="Celular" required>
                            </div>
                          </div>
                        </div>
                        <div class="uk-margin">
                          <input class="uk-input uk-form-small" type="email" name="email" placeholder="Correo" required>
                        </div>
                        <div class="uk-margin uk-text-center">
                          <button class="uk-button isee-background-green uk-light uk-text-bold" style="font-size: 1rem" type="submit">Enviarme cupón</button>
                        </div>
                      </form>
                    </div>
                    <div class="uk-text-center">
                      <a href="#" class="uk-modal-close">
                        <div class="uk-light uk-h5 uk-margin-remove uk-text-bold uk-text-underline" style="text-decoration: underline;">{{ $popup->text_close }}</div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  @endif
  {{-- END MODAL --}}

  <div class="uk-position-relative uk-background-secondary" id="slider">
    <div class="">
      @if (isset($sliders))
        <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider>
          <ul class="uk-slider-items uk-child-width-1-1">
            @foreach ($sliders as $slider)
              @if ($slider->buttons == 1)
                <li class="fade">
                  <div class="isee-slider-item uk-background-cover" style="background-image: url('{{ $slider->image }}')"></div>
                  <div class="uk-position-cover uk-overlay uk-flex uk-flex-center uk-flex-middle">
                    <div class="uk-width-2-3@s uk-width-1-1 uk-text-center">
                      <div class="uk-h0 uk-text-bold uk-light">
                        @lang('home.gafas-oftalmicas')
                      </div>
                      <div class="">
                        <div class="uk-margin-top">
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-2">
                              <a class="uk-text-bold uk-button uk-button-large isee-background-green uk-light isee-h4" href="/shop?attrs=oftalmico,hombre,unisex">@lang('home.hombre')</a>
                            </div>
                            <div class="uk-width-1-2">
                              <a class="uk-text-bold uk-button uk-button-large isee-background-green uk-light isee-h4" href="/shop?attrs=oftalmico,mujer,unisex">@lang('home.mujer')</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              @elseif ($slider->buttons == 2)
                <li class="fade">
                  <div class="isee-slider-item uk-background-cover" style="background-image: url('{{ $slider->image }}')"></div>                  
                  <div class="uk-position-cover uk-overlay uk-flex uk-flex-center uk-flex-middle">
                    <div class="uk-width-2-3@s uk-width-1-1 uk-text-center">
                      <div class="uk-h0 uk-text-bold uk-light">
                        @lang('attributes.multifocales')
                      </div>
                      <div class="">
                        <div class="uk-margin-top">
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-2">
                              <a class="uk-text-bold uk-button uk-button-large isee-background-green uk-light isee-h4" href="/shop?attrs=multifocales,hombre,unisex">@lang('home.hombre')</a>
                            </div>
                            <div class="uk-width-1-2">
                              <a class="uk-text-bold uk-button uk-button-large isee-background-green uk-light isee-h4" href="/shop?attrs=multifocales,mujer,unisex">@lang('home.mujer')</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              @elseif ($slider->buttons == 3)
                <li class="fade">
                  <div class="isee-slider-item uk-background-cover" style="background-image: url('{{ $slider->image }}')"></div>                  
                  <div class="uk-position-cover uk-overlay uk-flex uk-flex-center uk-flex-middle">
                    <div class="uk-width-2-3@s uk-width-1-1 uk-text-center">
                      <div class="uk-h0 uk-text-bold uk-light">
                        @lang('home.gafas-focales')
                      </div>
                      <div class="">
                        <div class="uk-margin-top">
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-2">
                              <a class="uk-text-bold uk-button uk-button-large isee-background-green uk-light isee-h4" href="/shop?attrs=solares,hombre,unisex">@lang('home.hombre')</a>
                            </div>
                            <div class="uk-width-1-2">
                              <a class="uk-text-bold uk-button uk-button-large isee-background-green uk-light isee-h4" href="/shop?attrs=solares,mujer,unisex">@lang('home.mujer')</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              @else
                <li class="fade">
                  <div class="isee-slider-item uk-background-cover" style="background-image: url('{{ $slider->image }}')"></div>
                  <div class="uk-position-cover uk-overlay uk-flex uk-flex-center uk-flex-middle">
                    <div class="uk-width-2-3@s uk-width-1-1 uk-text-center">
                      <div class="uk-h0 uk-text-bold uk-light">
                      </div>
                      <div class="">
                        <div class="uk-margin-top">
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-2">
                            </div>
                            <div class="uk-width-1-2">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              @endif
            @endforeach
          </ul>

          <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
          <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
        </div>
      @endif
    </div>
  </div>

  <promo-container :sections="sections"></promo-container>
  
  <div class="uk-section uk-section-small">
    <div class="uk-container uk-container-small">
      <div class="" uk-grid>
        <div class="uk-width-1-2@s uk-width-1-1">
          <div class="uk-inline uk-margin">
            <a href="/shop?attrs={{ $words }}">
              <img src="/pages/inicio/marcaspremium.jpg" alt="">
              <div class="uk-position-cover uk-overlay uk-flex uk-flex-center uk-flex-middle uk-text-uppercase isee-h2 uk-light uk-text-center uk-text-bold">@lang('home.marcas-premium')</div>
            </a>
          </div>
        </div>
        <div class="uk-width-1-2@s uk-width-1-1">
          <div class="">
            <div class="uk-inline uk-margin">
              <a href="/shop?cats=promociones">
                <img src="/pages/inicio/promociones.jpg" alt="">
                <div class="uk-position-cover uk-overlay uk-flex uk-flex-center uk-flex-middle uk-text-uppercase isee-h2 uk-light uk-text-center uk-text-bold">@lang('home.promociones')</div>
              </a>
            </div>
          </div>
          <div class="">
            <div class="uk-inline uk-margin">
              <a href="/shop?cats=novedades">
                <img src="/pages/inicio/novedades.jpg" alt="">
                <div class="uk-position-cover uk-overlay uk-flex uk-flex-center uk-flex-middle uk-text-uppercase isee-h2 uk-light uk-text-center uk-text-bold">@lang('home.novedades')</div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="">
    <hr>
  </div>

  <div class="uk-section uk-section-small">
    <div class="uk-container uk-container-small">
      <div class="uk-h2 uk-text-bold uk-text-center">
        @lang('home.styles')
      </div>
      <div class="uk-padding-small uk-text-center">
        <div class="uk-child-width-1-4@s uk-child-width-1-1 uk-grid-small" uk-grid>
          <div class="">
            <a class="uk-link-reset" href="/shop?attrs=rectangular">
              <img src="/pages/inicio/rectangular.jpg" alt="">
              <p class="isee-h6 uk-text-bold">
                @lang('home.rectangular')
              </p>
            </a>
          </div>
          <div class="">
            <a class="uk-link-reset" href="/shop?attrs=agatada">
              <img src="/pages/inicio/agatada.jpg" alt="">
              <p class="isee-h6 uk-text-bold">
                @lang('home.agatada')
              </p>
            </a>
          </div>
          <div class="">
            <a class="uk-link-reset" href="/shop?attrs=ovalada">
              <img src="/pages/inicio/ovalada.jpg" alt="">
              <p class="isee-h6 uk-text-bold">
                @lang('home.ovaladas')
              </p>
            </a>
          </div>
          <div class="">
            <a class="uk-link-reset" href="/shop?attrs=cuadrada">
              <img src="/pages/inicio/cuadrada.jpg" alt="">
              <p class="isee-h6 uk-text-bold">
                @lang('home.cuadrada')
              </p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="uk-background-muted">
    <div class="">
      <div class="uk-grid-collapse" uk-grid>
        <div class="uk-width-1-3@s uk-width-1-1">
          <div class="uk-inline uk-margin uk-width-1-1">
            <img class="uk-width-1-1" src="/pages/inicio/inicionuevo1.png" alt="">
            <div class="uk-position-small uk-position-top-center uk-overlay uk-light uk-text-bold uk-h2 uk-text-center">
              PRUÉBATE CUALQUIER LENTE
            </div>
            <div class="uk-position-small uk-position-bottom-right uk-overlay uk-light uk-text-bold uk-h2 uk-text-center">
              <a class="uk-button uk-button-default" href="#modal-inicio-1" uk-toggle>Leer más</a>
              <div id="modal-inicio-1" class="uk-modal-container" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                  <button class="uk-modal-close-default" type="button" uk-close></button>
                  <div class="uk-text-center">
                    <div class="uk-margin-medium">
                      <div class="uk-width-3-5@s uk-width-1-1 uk-margin-auto">
                        <div class="uk-h2 uk-text-bold">
                          APRENDE A USAR NUESTRO PROBADOR VIRTUAL
                        </div>
                      </div>
                    </div>
                    <div class="uk-margin">
                      <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-large" uk-grid>
                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop11.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove">
                            <strong style="1.2rem;">1. </strong>
                            Busca los lentes que más te gusten
                          </div>
                        </div>

                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop12.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove">
                            <strong style="1.2rem;">2. </strong>
                            Dale click al botón "Pruébame"
                          </div>
                        </div>

                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop13.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove">
                            <strong style="1.2rem;">3. </strong>
                            Elige la opción de "Tomar foto" o "Subir foto"
                          </div>
                        </div>

                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop14.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove">
                            <strong style="1.2rem;">4. </strong>
                            Coloca los puntitos verdes sobre tus ojos y listo
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="uk-margin">
                      <div class="uk-width-1-2@s uk-width-1-1 uk-margin-auto uk-visible@s">
                        <div class="uk-flex uk-flex-between uk-text-center" uk-grid>
                          <div class="">
                            <a class="uk-button uk-background-primary uk-light uk-button-large isee-button-size" href="/shop/3269">
                              HOMBRE
                            </a>
                          </div>
                          <div class="">
                            <a class="uk-button isee-background-green uk-button-large uk-light isee-button-size" href="/shop/a14530">
                              MUJER
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="uk-hidden@s">
                        <div class="uk-grid-small" uk-grid>
                          <div class="uk-width-1-1">
                            <a class="uk-button uk-background-primary uk-light uk-button-large isee-button-size" href="/shop/3269">
                              HOMBRE
                            </a>
                          </div>
                          <div class="uk-width-1-1">
                            <a class="uk-button isee-background-green uk-button-large uk-light isee-button-size" href="/shop/a14530">
                              MUJER
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-width-1-3@s uk-width-1-1">
          <div class="uk-inline uk-margin uk-width-1-1">
            <img class="uk-width-1-1" src="/pages/inicio/inicionuevo2.png" alt="">
            <div class="uk-position-small uk-position-top-center uk-overlay uk-light uk-text-bold uk-h2 uk-text-center">
              LENTES INCLUYEN LUNAS BÁSICAS GRATIS
            </div>
            <div class="uk-position-small uk-position-bottom-right uk-overlay uk-light uk-text-bold uk-h2 uk-text-center">
              <a class="uk-button uk-button-default" href="#modal-inicio-2" uk-toggle>Leer más</a>
              <div id="modal-inicio-2" class="uk-modal-container" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                  <button class="uk-modal-close-default" type="button" uk-close></button>
                  <div class="uk-text-center">
                    <div class="uk-margin">
                      <div class="uk-width-1-2@s uk-width-1-1 uk-margin-auto">
                        <div class="uk-h2 uk-text-bold uk-margin-small">
                          TODAS NUESTRAS GAFAS OFTÁLMICAS INCLUYEN GRATIS LUNA DE MEDIDA
                        </div>
                        <div class="uk-h4 uk-text-bold uk-margin-remove">
                          Las lunas de medida gratis son:
                        </div>
                      </div>
                    </div>
                    <div class="uk-margin-small">
                      <div class="uk-child-width-1-3@s uk-child-width-1-1" uk-grid>
                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop21.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove">
                            <strong style="1.2rem;">1. </strong>
                            De Resina con protección UV
                          </div>
                        </div>

                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop22.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove">
                            <strong style="1.2rem;">2. </strong>
                            Medidas máximas de: Esfera +/- 4.00 y/o Cilindro +/- 2.00
                          </div>
                        </div>

                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop23.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove">
                            <strong style="1.2rem;">3. </strong>
                            Monofocales
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="uk-margin">
                      <div class="uk-text-center uk-h3 uk-text-bold">
                        ¿QUIERES VER NUESTRO CATÁLOGO?
                      </div>
                    </div>
                    <div class="uk-margin">
                      <div class="uk-width-1-2@s uk-width-1-1 uk-margin-auto uk-visible@s">
                        <div class="uk-flex uk-flex-between uk-text-center" uk-grid>
                          <div class="">
                            <a class="uk-button uk-background-primary uk-light uk-button-large isee-button-size" href="/shop?attrs=hombre,unisex">
                              HOMBRE
                            </a>
                          </div>
                          <div class="">
                            <a class="uk-button isee-background-green uk-button-large uk-light isee-button-size" href="/shop?attrs=mujer,unisex">
                              MUJER
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="uk-hidden@s">
                        <div class="uk-grid-small" uk-grid>
                          <div class="uk-width-1-1">
                            <a class="uk-button uk-background-primary uk-light uk-button-large isee-button-size" href="/shop?attrs=hombre,unisex">
                              HOMBRE
                            </a>
                          </div>
                          <div class="uk-width-1-1">
                            <a class="uk-button isee-background-green uk-button-large uk-light isee-button-size" href="/shop?attrs=mujer,unisex">
                              MUJER
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-width-1-3@s uk-width-1-1">
          <div class="uk-inline uk-margin uk-width-1-1">
            <img class="uk-width-1-1" src="/pages/inicio/inicionuevo3.png" alt="">
            <div class="uk-position-small uk-position-top-center uk-overlay uk-light uk-text-bold uk-h2 uk-text-center">
              ¿SABES LO FÁCIL QUE ES COMPRAR TUS LENTES CON LUNAS DE MEDIDA?
            </div>
            <div class="uk-position-small uk-position-bottom-right uk-overlay uk-light uk-text-bold uk-h2 uk-text-center">
              <a class="uk-button uk-button-default" href="#modal-inicio-3" uk-toggle>Leer más</a>
              <div id="modal-inicio-3" class="uk-modal-container" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                  <button class="uk-modal-close-default" type="button" uk-close></button>
                  <div class="uk-text-center">
                    <div class="uk-margin">
                      <div class="uk-width-1-2@s uk-width-1-1 uk-margin-auto">
                        <div class="uk-h2 uk-text-bold uk-margin-small">
                          COMPRAR EN I-SEE ES MUY FÁCIL
                        </div>
                      </div>
                    </div>
                    <div class="uk-margin-medium">
                      <div class="uk-child-width-1-4@s uk-child-width-1-2" uk-grid>
                        <div class="">
                          <a class="uk-link-reset isee-zoom" href="/registrar">
                            <div class="isee-body-zoom">
                              <div class="uk-margin">
                                <img class="uk-border-circle" src="/pages/inicio/pop31.png" alt="">
                              </div>
                              <div class="uk-h4 uk-margin-remove uk-width-2-3@s uk-width-1-1 uk-margin-auto">
                                <strong style="1.2rem;">1. </strong>
                                Regístrate en <br> I-SEE
                              </div>
                            </div>
                          </a>
                        </div>

                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop32.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove uk-width-2-3@s uk-width-1-1 uk-margin-auto">
                            <strong style="1.2rem;">2. </strong>
                            Elige tus lentes
                          </div>
                        </div>

                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop33.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove uk-width-2-3@s uk-width-1-1 uk-margin-auto">
                            <strong style="1.2rem;">3. </strong>
                            Ingresa tu prescripción
                          </div>
                        </div>

                        <div class="">
                          <div class="uk-margin">
                            <img class="uk-border-circle" src="/pages/inicio/pop34.png" alt="">
                          </div>
                          <div class="uk-h4 uk-margin-remove uk-width-2-3@s uk-width-1-1 uk-margin-auto">
                            <strong style="1.2rem;">4. </strong>
                            Añade tu compra al carrito
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="uk-margin">
                      <div class="uk-text-center uk-h3 uk-text-bold">
                        ¿QUIERES VER NUESTRO CATÁLOGO?
                      </div>
                    </div>
                    <div class="uk-margin">
                      <div class="uk-width-1-2@s uk-width-1-1 uk-margin-auto uk-visible@s">
                        <div class="uk-flex uk-flex-between uk-text-center" uk-grid>
                          <div class="uk-text-center">
                            <a class="uk-button uk-background-primary uk-light uk-button-large isee-button-size" href="/shop?attrs=hombre,unisex">
                              HOMBRE
                            </a>
                          </div>
                          <div class="uk-text-center">
                            <a class="uk-button isee-background-green uk-button-large uk-light isee-button-size" href="/shop?attrs=mujer,unisex">
                              MUJER
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="uk-hidden@s">
                        <div class="uk-grid-small" uk-grid>
                          <div class="uk-width-1-1">
                            <a class="uk-button uk-background-primary uk-light uk-button-large isee-button-size" href="/shop?attrs=hombre,unisex">
                              HOMBRE
                            </a>
                          </div>
                          <div class="uk-width-1-1">
                            <a class="uk-button isee-background-green uk-button-large uk-light isee-button-size" href="/shop?attrs=mujer,unisex">
                              MUJER
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('js')
  <script>
    $('#openModalTop').click(function(){
      $('.widget-small').css('bottom','2vh')
      $('#mobileModalBottom').addClass('uk-hidden')
      $('#mobileModalBottom').removeClass('uk-hidden@s')
      $('#mobileModalTop').removeClass('uk-hidden')
      $('#mobileModalTop').addClass('uk-hidden@s')
    });

    $('#closeModalBottom').click(function(){
      $('.widget-small').css('bottom','2vh')
      $('#mobileModalBottom').addClass('uk-hidden')
      $('#mobileModalBottom').removeClass('uk-hidden@s')
    });

    $('#closeModalTop').click(function(){
      $('.widget-small').css('bottom','62px')
      $('#mobileModalTop').addClass('uk-hidden')
      $('#mobileModalTop').removeClass('uk-hidden@s')
      $('#mobileModalBottom').removeClass('uk-hidden')
      $('#mobileModalBottom').addClass('uk-hidden@s')
    });
  </script>
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

  @if (isset($status))
    @if (isset($popup) && $status)
      <script>
        var widthScreen = $(window).width();
        if (widthScreen > '640') {
          window.onload = function() {
            UIkit.modal('#modal-center').show();
          }
        }
      </script>
    @endif
  @endif
@endpush
