@extends('layouts.site')

@push('head')
  <script>
    window.statics = {
      titles: JSON.parse('{!! collect(__("shop"))->toJson() !!}'),
      lang: '{!! App::getLocale() !!}'
    }

    window.state = {
      user: JSON.parse('{!! Auth::check() ? Auth::user()->toJson() : "null" !!}'),
      client: JSON.parse('{!! Auth::check() ? Auth::user()->is_client() ? Auth::user()->client->toJson() : "null" : "null" !!}'),
      wishes: JSON.parse('{!! Auth::check() ? Auth::user()->wishes->toJson() : "null" !!}'),
      query: JSON.parse('{!! $query->toJson() !!}')
    }

  </script>
@endpush

@push('js')
  <script src="{{ mix('js/site/shop2.js') }}"></script>
@endpush

@section('content')
  @php
    if (Auth::check()) {
      $rate_slug = Auth::user()->rate->slug;
    } else {
      if (session()->has('rateslug')) {
        $rate_slug = session()->get('rateslug');
      }else {
        $rate_slug = null;
      }
    }
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
  {{-- client: JSON.parse('{!! !Auth::check() ? "null" : Auth::user()->is_client() ? Auth::user()->client->toJson() : "null" !!}'), --}}


  <isee-shop :rateslug="'{{ $rate_slug }}'" :rates="{{ $rates->toJson() }}"></isee-shop>
@endsection

@push('js')
  <script>
    window.onload = function() {
      window.localStorage.removeItem('shop-filters');
    }
  </script>
@endpush
