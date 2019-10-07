<div class="uk-section uk-section-xsmall isee-padding-empty" style="z-index: 99;">
  <div class="uk-container uk-visible@m">
    <nav class="uk-navbar-container uk-navbar-transparent uk-navbar" uk-navbar>
      <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
          @if (Auth::guest())
            <li><a href="#modal-login" uk-toggle uk-icon="icon: cart"></a></li>
            <li><a href="#modal-login" uk-toggle uk-icon="icon: user" title="Login" uk-tooltip></a></li>
          @else
            @if (Auth::user()->is_administrator())
              <li><a href="/admin/show-orders/1" style="font-size: 14px;">@lang('nav.saludo'), {{ Auth::user()->first_name }}</a></li>
            @else
              <li><a href="/profile" style="font-size: 14px;">@lang('nav.saludo'), {{ Auth::user()->first_name }}</a></li>
            @endif
            <li><a href="{{ url('/cart') }}" uk-icon="icon: cart"></a></li>
            <li><a href="{{ route('logout') }}" data-method="post" uk-icon="icon: sign-out"></a></li>
          @endif
          @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <li>
              <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                {{ $properties['native'] }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </nav>
  </div>
</div>

<hr class="isee-hr isee-padding-empty uk-visible@m">

<div id="navbar" class="isee-padding-xsmall uk-background-default uk-width-1-1" style="z-index: 980" uk-sticky="bottom: #offset">
  <div class="uk-container">
    <nav class="uk-navbar-container uk-navbar-transparent uk-navbar" uk-navbar>
      <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo" href="/">
          <img class="uk-width-1-1@s uk-width-3-4" src="/pages/inicio/logo.png" alt="">
        </a>
      </div>
      <div class="uk-navbar-right uk-visible@s">
        <ul class="uk-navbar-nav isee-navbar-right">
          <li class="isee-hover uk-visible@m">
            <a href="/shop">@lang('nav.catalogo')</a>
            <div class="uk-navbar-dropdown uk-navbar-dropdown-width-4" uk-drop="boundary: !nav; boundary-align: true; pos: bottom-justify; " style="margin-top: 0px">
              <div class="uk-navbar-dropdown-grid uk-child-width-1-2" uk-grid>
                <div class="">
                  <div class="uk-child-width-1-2" uk-grid>
                    <div class="">
                      <a href="/shop?attrs=hombre,unisex">
                        <img src="/pages/inicio/hombremenu.jpg" alt="">
                      </a>
                    </div>
                    <div class="">
                      <ul class="uk-nav uk-navbar-dropdown-nav">
                        <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/shop?attrs=hombre,unisex,oftalmico">@lang('attributes.oftalmico')</a></li>
                        <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/shop?attrs=hombre,unisex,,multifocales">@lang('attributes.multifocales')</a></li>
                        <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/shop?attrs=hombre,unisex,solares">@lang('attributes.gafas-sol')</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="">
                    <div class="uk-child-width-1-2" uk-grid>
                      <div class="">
                        <a href="/shop?attrs=mujer,unisex">
                          <img src="/pages/inicio/mujermenu.jpg" alt="">
                        </a>
                      </div>
                      <div class="">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                          <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/shop?attrs=mujer,unisex,oftalmico">@lang('attributes.oftalmico')</a></li>
                          <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/shop?attrs=mujer,unisex,multifocales">@lang('attributes.multifocales')</a></li>
                          <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/shop?attrs=mujer,unisex,solares">@lang('attributes.gafas-sol')</a></li>
                        </ul>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </li>
          <li class="isee-hover uk-visible@l">
            <a href="/shop?cats=promociones">@lang('nav.promociones')</a>
          </li>
          <li class="isee-hover uk-visible@m">
            <a href="/nosotros">@lang('nav.nosotros')</a>
            <div class="uk-navbar-dropdown" style="width: 240px;">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                @if (Route::currentRouteName() == 'nosotros')
                  <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" uk-scroll="offset: 30" href="/nosotros#empresa">@lang('nav.empresa')</a></li>
                  <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" uk-scroll="offset: 30" href="/nosotros#beneficios">@lang('nav.beneficios')</a></li>
                  <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" uk-scroll="offset: 30" href="/nosotros#afiliacion">@lang('nav.afiliacion')</a></li>
                @else
                  <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/nosotros#empresa">@lang('nav.empresa')</a></li>
                  <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/nosotros#beneficios">@lang('nav.beneficios')</a></li>
                  <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/nosotros#afiliacion">@lang('nav.afiliacion')</a></li>
                @endif
                @if (Auth::guest())
                  <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="#modal-login" uk-toggle>TRACKEO DE PAQUETES</a></li>
                @else
                  @if (!Auth::user()->is_administrator())
                    <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/my-orders">TRACKEO DE PAQUETES</a></li>
                  @endif
                @endif
                <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/faq">@lang('nav.faq')</a></li>
                <li class="uk-active"><a class="isee-h6 isee-color uk-text-bold" href="/terminos-y-condiciones">@lang('nav.terminos')</a></li>
              </ul>
            </div>
            </li>
          <li class="isee-hover uk-visible@m">
            <a href="/contactanos">@lang('nav.contactanos')</a>
          </li>
          @if (Auth::guest())
            <li class="isee-hover uk-visible@m"><a href="#modal-login" uk-toggle uk-icon="icon: cart"></a></li>
          @else
            <li class="isee-hover uk-visible@m"><a href="{{ url('/cart') }}" uk-icon="icon: cart"></a></li>
          @endif
        </ul>
      </div>

      <div class="uk-navbar-right uk-hidden@l">
        <a class="uk-navbar-toggle" uk-navbar-toggle-icon href="#" uk-toggle="target: #offcanvas-flip"></a>
      </div>
    </nav>
  </div>
</div>

<div id="offcanvas-flip" uk-offcanvas="overlay: true; flip: true">
  <div class="uk-offcanvas-bar">
    <div class="uk-margin-small-top">
      <ul class="uk-nav uk-nav-default">
        <li><a href="/">@lang('nav.inicio')</a></li>
        <li><a href="{{ url('/shop') }}">@lang('nav.catalogo')</a></li>
        <li><a href="/shop?cats=promociones">@lang('nav.promociones')</a></li>
        <li>
          <a href="{{ url('/nosotros') }}">@lang('nav.nosotros')</a>
          <div class="uk-padding-small">
            <ul class="uk-list">
              <li class="isee-h6"><a href="{{ url('/nosotros#empresa') }}">@lang('nav.empresa')</a></li>
              <li class="isee-h6"><a href="{{ url('/nosotros#beneficios') }}">@lang('nav.beneficios')</a></li>
              <li class="isee-h6"><a href="{{ url('/nosotros#afiliacion') }}">@lang('nav.afiliacion')</a></li>
              <li class="isee-h6"><a href="{{ url('/faq') }}">@lang('nav.faq')</a></li>
              <li class="isee-h6"><a href="{{ url('/terminos-y-condiciones') }}">@lang('nav.terminos')</a></li>
            </ul>
          </div>
        </li>
        <li><a href="{{ url('/contactanos') }}">@lang('nav.contactanos')</a></li>
        @if (Auth::guest())
          <li><a href="#modal-login" uk-toggle>LOGIN</a></li>
          <li><a href="#modal-login" uk-toggle uk-icon="icon: cart"></a></li>
        @else
          @if (Auth::user()->is_administrator())
            <li><a href="{{ url('/admin/show-orders/1') }}">@lang('nav.mi-cuenta')</a></li>
          @else
            <li><a href="{{ url('/profile') }}">@lang('nav.mi-cuenta')</a></li>
            <li><a href="{{ url('/cart') }}">@lang('nav.carrito')</a></li>
            <li><a href="{{ url('/my-orders') }}">@lang('nav.ordenes')</a></li>
            <li><a href="{{ url('/wishlist') }}">@lang('nav.wishlist')</a></li>
          @endif
          <li><a href="{{ route('logout') }}" data-method="post" uk-icon="icon: sign-out">SALIR </a></li>
        @endif

        {{-- <li>
          @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <span>
              <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                <span class="uk-text-bold">{{ $properties['native'] }}</span>
              </a>
            </span>
          @endforeach
        </li> --}}

      </ul>
    </div>
  </div>
</div>

@include('site.partials.modal_login')

@isset($errors)
  @if ($errors->has('email'))
    <script>
    UIkit.notification({
      message: '<span uk-icon="icon: warning"></span> Correo o contraseña inválidos.',
      status: 'danger',
      pos: 'bottom-center',
      timeout: 0
    });
    </script>
  @endif
@endisset

@push('js')
  <script>
    var token = $('meta[name="csrf-token"]').attr('content')
    $('.login-form').submit(function(e) {
      e.preventDefault()

      $.ajax({
        url: "/login",
        type: "POST",
        data: $('.login-form').serialize(),
        dataType: "JSON",
        beforeSend: function(){
          $(".login").show();
        }
      }).done(function(data){
        if (data.success) {
          window.location.reload();
        }else {
          $('#error').removeClass('uk-hidden')
        }
        $(".login").hide();
      });
    })
  </script>
@endpush
