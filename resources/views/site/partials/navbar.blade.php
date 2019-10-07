@extends('layouts.site')

@section('content')

  <div class="uk-section-muted">
    <div class="uk-container">
      <div class="" uk-grid>
        <div class="uk-visible@m uk-width-1-4">
          <div class="uk-padding-small uk-background-primary uk-height-1-1">
            <div class="uk-navbar-transparent uk-light">
              <h5 class="uk-margin-small">Bienvenido,</h5>
              <h3 class="uk-text-center uk-text-uppercase uk-text-bold uk-margin-small">{{ Auth::user()->first_name }}</h3>
              {{-- <h4>{{Auth::user()->role->name}}</h4> --}}
              <ul class="uk-margin-medium uk-nav-default uk-nav-parent-icon" uk-nav="multiple: true">
                <li class="uk-active"><a href="/profile">@lang('navbar.perfil')</a></li>
                @if (Auth::user()->is_administrator())
                  <li class="uk-active"><a href="#">Clientes</a></li>
                  <li class="uk-active"><a href="#">Administradores</a></li>
                  <li class="uk-active"><a href="#">Atributos</a></li>
                  <li class="uk-active"><a href="#">Caraterísticas</a></li>
                  <li class="uk-active"><a href="#">Productos</a></li>
                  <li class="uk-active"><a href="#">Categorías</a></li>
                @endif
                <li class="uk-active"><a href="/my-orders">@lang('navbar.ordenes')</a></li>
                <li class="uk-active"><a href="/wishlist">@lang('navbar.wishlist')</a></li>
                @if (Auth::user()->is_affiliate())
                  <li class="uk-active"><a href="/promotions">@lang('navbar.affiliate')</a></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
        <div class="uk-width-expand">
          @yield('navbar')
        </div>
      </div>
    </div>
  </div>

@endsection
