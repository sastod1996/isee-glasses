<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-param" content="_token">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" href="/pages/favicon.ico">

  <title>{{ config('app.name', 'I-SEE') }}</title>

  <!-- Styles -->
  <link href="{{ mix('css/admin/app.css') }}" rel="stylesheet">
  @stack('head')
  @stack('css')
  <script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=lziqecukba0cqz33nlqzq8tswreqjzegmiv799pkhkopt5my'></script>
  <script>
    tinymce.init({
      selector: '.textarea-form'
    });
  </script>
  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
    ]) !!};
  </script>
</head>
<body>
  <div class="uk-offcanvas-content">
    @include('admin.partials._navbar')
    <div id="app" class="uk-section uk-container">
      @yield('content')
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ mix('js/admin/app.js') }}"></script>
  @stack('js')

  @isset($errors)
    @if ($errors->has('status'))
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
</body>
</html>
