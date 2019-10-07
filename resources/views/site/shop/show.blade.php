@push('meta')
  <meta property="og:url" content="https://isee-glasses.com/shop/{{ $product->slug }}" />
  <meta property="og:title" content="I-SEE | {{ $product->name }}" />
  <meta property="og:description" content="{{ $product->description }}" />
  <meta property="og:image" content="{{ $product->image }}">
@endpush

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.22/fabric.min.js"></script>
  <script src="/assets/tester/GlassTester.umd.min.js?181226"></script>
  <script>
    Vue.component('GlassTester', window.GlassTester)
  </script>
  <script src="{{ mix('js/site/product.js') }}"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="/assets/tester/GlassTester.css?181226">
  <link rel="stylesheet" href="/css/site/pages/product.css">
@endpush

@extends('layouts.site')

@section('content')

  @php
    if (Auth::check()) {
      $rate_slug = Auth::user()->rate->slug;
    } else {
      if (session()->has('rateslug')) {
        $rate_slug = session()->get('rateslug');
      } else {
        $rate_slug = null;
      }
    }

    //Archivo de lenguaje
    $titles = __('shop');
    $titles = json_decode(json_encode($titles));
    $titles = collect($titles);

    $login = __('nav_vue');
    $login = json_decode(json_encode($login));
    $login = collect($login);

    $lang = App::getLocale();
  @endphp

  <product :lang ="'{{$lang}}'" :titles="{{ $titles->toJson() }}" :login="{{ $login->toJson() }}" :rateslug="'{{ $rate_slug }}'" :product="{{ $product->toJson() }}" :warranties="{{ $warranties->toJson() }}" :types="{{ $types->toJson() }}" :rates="{{ $rates->toJson() }}" :user="{{ isset($user) ? $user->toJson() : 0 }}"></product>
@endsection
