@push('css')
<link rel="stylesheet" href="{{ mix('css/site/pages/shop.css') }}">
@endpush

@push('js')
  <script src="{{ mix('js/site/shop.js') }}"></script>
@endpush

@extends('layouts.site')

@section('content')

  @php
    if (Auth::check()) {
      $rate_slug = Auth::user()->rate->slug;
    } else {
      if (session()->has('rateslug')) {
        $rate_slug = session()->get('rateslug');
      }else {
        $rate_slug = 'soles';
      }
    }
    //Archivo de lenguaje
    $titles = __('shop');
    $titles = json_decode(json_encode($titles));
    $titles = collect($titles);

    $lang = App::getLocale();
  @endphp

  <div class="uk-section uk-background-cover uk-light uk-background-secondary" style="background-image: url('/pages/catalogo/catalogo.jpg');">
    <div class="uk-section-small uk-text-center">
      <div class="uk-container uk-container-small">
        <div class="uk-padding-large">
          <h1 class="uk-h0 isee-bold">
            @lang('shop.catalogo')
          </h1>
        </div>
      </div>
    </div>
  </div>

  {{-- <div id="shop">
    <shop :user="{{ isset($user) ? $user->toJson() : 0 }}" :lang="'{{ $lang }}'" :titles="{{ $titles->toJson() }}" :rateslug="'{{ $rate_slug }}'" :products="{{ $products->toJson() }}" :categories="{{ $categories->toJson() }}" :characteristics="{{ $characteristics->toJson() }}" :rates="{{ $rates->toJson() }}" :primaries="{{ $primaries->toJson() }}"></shop>
  </div> --}}

@endsection

@push('js')
  @if (session('status'))
    @php
      $status = session('status');
    @endphp
    <script type="text/javascript">
      UIkit.notification({
        message: '<span uk-icon="icon: check"></span>{{ $status }}',
        status: 'danger',
        pos: 'bottom-center',
        timeout: 5000
      });
    </script>
  @endif

@endpush
