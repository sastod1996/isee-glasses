<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="lentes de sol, lentes, gafas ópticas, multifocales, gafas de sol, ray ban, oakley, compra online, lentes oftálmicos, gafas baratas, lentes online, gafas online, marcas de lentes, lentes precios, lentes para leer, lentes para ver de cerca, lentes para ver de lejos, aviador, cat eye, comprar lentes, gmo, econolentes, visioncenter"/>

  <!-- CSRF Token -->
  <meta name="csrf-param" content="_token">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta property="og:type" content="website" />
  @stack('meta')

  <link rel="shortcut icon" href="/pages/favicon.ico">

  <title>{{ config('app.name', 'I-SEE') }}</title>

  <!-- Styles -->
  <link href="{{ mix('css/site/app.css') }}" rel="stylesheet">
  @stack('css')

  @stack('head')
  {{-- <script src="{{ mix('js/site/app.js') }}"></script> --}}
  <script>
    window.Laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
    ]) !!};
  </script>

</head>
<body>
  <div class="" id="navbar">
    @include('site.partials.nav')
  </div>
  <div class="" id="app">
    @yield('content')
  </div>
  <div class="">
    @include('site.partials.footer')
  </div>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js" charset="utf-8"></script>
  <script src="{{ mix('js/site/app.js') }}"></script>
  @stack('js')
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109078000-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-109078000-1');
  </script>

</body>
</html>
