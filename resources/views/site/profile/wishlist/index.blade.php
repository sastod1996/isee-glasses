@push('css')
  <link rel="stylesheet" href="/css/site/pages/wishlist.css">
@endpush

@extends('site.partials.navbar')

@section('navbar')

  @php
    $symbol = Auth::user()->rate->symbol;
    $value = Auth::user()->rate->value;
  @endphp

  <div id="wishlist" class="uk-section uk-section-small">
    <div class="uk-container uk-container-small">
      @if (sizeof($wishes) > 0)
        <div class="uk-h2 uk-text-center isee-bold isee-spacing-small">
          LISTA DE DESEOS
        </div>
        <div class="">
          <div class="" style="padding-top: 1.5rem;">
            <div class="">
              <div class="">
                @foreach ($wishes as $item)
                  @if (($loop->index != count($wishes)) && ($loop->index != 0))
                    <div class="uk-margin">
                      <hr class="isee-hr">
                    </div>
                  @endif
                  <div class="uk-margin">
                    <div class="" uk-grid>
                      <div class="uk-width-1-3@s uk-width-1-1">
                        <div class="">
                          <a href="/shop/{{ $item->slug }}">
                            <img src="{{ asset($item->image) }}" alt="" style="">
                          </a>
                        </div>
                      </div>
                      <div class="uk-width-1-2@s uk-width-1-1">
                        <p class="isee-h3 uk-margin-small uk-text-bold">{{ $item->name }} ({{ $item->code }})</p>
                        <p class="uk-margin-small">{{ $item->description }}</p>
                        {{-- <p class="isee-h5 uk-margin-small isee-bold">TIPO</p> --}}
                        {{-- <p class="uk-margin-small">SOLAR</p> --}}
                      </div>
                      <div class="uk-width-1-6@s uk-width-1-1 uk-inline">
                        <div class="uk-position-top-right">
                          <a class="uk-link-reset" href="{{ route('wishlist.destroy', $item->id) }}" data-method="delete" data-confirm="¿Desea eliminar este producto de la lista de deseos?" data-method="delete">
                            Eliminar
                            <span uk-icon="icon: close; ratio: 1.2"></span>
                          </a>
                        </div>
                        <div class="uk-position-bottom-right">
                          <div class="isee-h3 uk-text-bold">
                            {{ $symbol }} <span>{{ convertRate($item->price, $value) }}</span>
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
      @else
        <div class="uk-h1 uk-text-center isee-bold isee-spacing-small">
          LISTA DE DESEOS VACÍA
        </div>
        <div class="uk-h4 uk-text-center isee-bold">
          IR A <a class="uk-link-reset" href="/shop">TIENDA</a>
        </div>
      @endif
    </div>
  </div>

@endsection
