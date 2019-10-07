@push('css')
  <link rel="stylesheet" href="/css/site/pages/nosotros.css">
@endpush

@extends('layouts.site')

@section('content')

  <div class="uk-section uk-background-cover uk-light uk-background-secondary" style="background-image: url('/pages/nosotros/sobrenosotros.jpg');">
    <div class="uk-section-small uk-text-center">
      <div class="uk-container uk-container-small">
        <div class="uk-padding-large">
          <h1 class="uk-h0 isee-bold">
            @lang('nosotros.nosotros')
          </h1>
        </div>
      </div>
    </div>
  </div>

  <div id="empresa" class="uk-section">
    <div class="uk-container uk-container-small">
      <div class="uk-h2 uk-text-bold uk-text-center">
        @lang('nosotros.nosotros')
      </div>
      <div class="isee-h4 uk-text-justify">
        <p>
          @lang('nosotros.descripcion1')
        </p>
        <p>
          @lang('nosotros.descripcion2')
        </p>
        <p>
          @lang('nosotros.descripcion3')
        </p>
      </div>
    </div>
  </div>

  <div class="uk-container uk-container-small">
    <hr>
  </div>

  <div id="beneficios" class="uk-section">
    <div class="uk-container">
      <div class="uk-h2 uk-text-bold uk-text-center">
        @lang('nosotros.beneficios')
      </div>
      <div class="uk-padding uk-text-center">
        <div class="uk-child-width-1-3@s uk-width-1-1 uk-flex uk-flex-center uk-grid-collapse" uk-grid>
          @php
            $circles = json_decode(json_encode([
              ['front' => '/pages/nosotros/beneficio1.jpg', 'back' => 'Podrás ver una gran variedad de lentes desde la comodidad de tu casa.'],
              ['front' => '/pages/nosotros/beneficio2.jpg', 'back' => 'Al comprar online a través de nuestra web, podrás estar seguro que estarás ahorrando y adquiriendo productos de calidad.'],
              ['front' => '/pages/nosotros/beneficio3.jpg', 'back' => 'El saber cómo te quedarán los lentes no es un problema con nuestro probador de gafas usando tu cámara web.'],
              ['front' => '/pages/nosotros/beneficio5.jpg', 'back' => 'Si las gafas que compraste no te quedan como imaginaste, ponte en contacto con nosotros para generar la devolución total de tu dinero.'],
              ['front' => '/pages/nosotros/beneficio4.jpg', 'back' => 'Te enviaremos tus gafas completamente gratis estés donde estés.']
            ]));
          @endphp
          @foreach ($circles as $item)
            <div>
              <div class="flip-container uk-margin-auto" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                  <div class="front">
                    <img src="{{ $item->front }}" alt="">
                    {{-- <img class="uk-border-circle" src="/pages/nosotros/beneficio{{ $item->front }}.jpg" alt=""> --}}
                  </div>
                  <div class="back uk-border-circle uk-flex-middle uk-flex-center uk-flex uk-background-muted">
                    <div class="uk-padding">
                      <p class="uk-text-bold">{{ $item->back }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <div class="uk-container uk-container-small">
    <hr>
  </div>

  <div id="afiliacion" class="uk-section">
    <div class="uk-container">
      <div class="uk-h2 uk-text-bold uk-text-center">
        @lang('nosotros.afiliacion')
      </div>
      <div class="uk-container uk-container-small">
        <p>
          @lang('nosotros.afiliacion-desc')
        </p>
        <div class="uk-margin-large-top">
          <div class="uk-h4 uk-text-bold">@lang('nosotros.question1')</div>
          <div class="" uk-grid>
            <div class="uk-width-1-5@s uk-width-1-1 uk-text-center">
              <img src="/pages/nosotros/iconoafiliacion1.jpg" alt="">
            </div>
            <div class="uk-width-4-5@s uk-width-1-1">
              <p class="uk-text-justify">
                @lang('nosotros.answer1')
              </p>
            </div>
          </div>
        </div>
        <div class="uk-margin-large-top">
          <div class="uk-h4 uk-text-bold">@lang('nosotros.question2')</div>
          <div class="" uk-grid>
            <div class="uk-width-4-5@s uk-width-1-1">
              <p class="uk-text-justify">
                @lang('nosotros.answer2')
              </p>
            </div>
            <div class="uk-width-1-5@s uk-width-1-1 uk-text-center">
              <img src="/pages/nosotros/iconoafiliacion2.jpg" alt="">
            </div>
          </div>
        </div>
        <div class="uk-margin-large-top">
          <div class="uk-h4 uk-text-bold">@lang('nosotros.question3')</div>
          <div class="" uk-grid>
            <div class="uk-width-1-5@s uk-width-1-1 uk-text-center">
              <img src="/pages/nosotros/iconoafiliacion3.jpg" alt="">
            </div>
            <div class="uk-width-4-5@s uk-width-1-1">
              <ul class="uk-list-line">
                <li>
                   @lang('nosotros.answer3-1')
                </li>
                <li>
                  @lang('nosotros.answer3-2')
                </li>
                <li>
                  @lang('nosotros.answer3-3')
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="uk-margin-large-top">
          <div class="uk-text-center">
            {{-- @if (Auth::check()) --}}
              @if (Auth::check() && Auth::user()->is_affiliate())
                <a class="isee-h4 uk-button uk-button-large uk-light isee-bold isee-background-green" href="/promotions">@lang('nosotros.quiero-afiliarme')</a>
              @else
                <a class="isee-h4 uk-button uk-button-large uk-light isee-bold isee-background-green" href="/afiliarme">@lang('nosotros.quiero-afiliarme')</a>
              @endif
              {{-- <a class="isee-h4 uk-button uk-button-large uk-light isee-bold isee-background-green" href="#" uk-toggle="target: #afiliacion-modal">@lang('nosotros.quiero-afiliarme')</a> --}}
            {{-- @else --}}
              {{-- <a class="isee-h4 uk-button uk-button-large uk-light isee-bold isee-background-green" href="#modal-login" uk-toggle>@lang('nosotros.quiero-afiliarme')</a> --}}
            {{-- @endif --}}
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('js')
    <script>
      var path = window.location.href.split('#')
      if (path[1]) {
        UIkit.scroll($('<a></a>'), { offset: 50 }).scrollTo("#"+path[1]);
      }
    </script>
  @endpush

@endsection
