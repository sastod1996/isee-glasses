<div class="uk-container uk-container-expand uk-background-primary">
  <nav class="uk-navbar" uk-navbar>
    <div class="uk-navbar-left">
      @unless (Auth::guest())
        <a class="uk-icon uk-light" uk-icon="icon: menu" uk-toggle="target: #menu"></a>
      @endunless
      <div class="uk-navbar-item uk-logo">
        I-SEE
      </div>
      {{-- Off-canvas --}}
      @unless (Auth::guest())
        <div class="uk-offcanvas" id="menu" uk-offcanvas="overlay: true">
          <div class="uk-offcanvas-bar">
            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <h2 class="uk-text-bold">I-SEE</h2>
            <p>
              @include('admin.partials.sidebar')
            </p>
          </div>
        </div>
      @endunless
    </div>
    <div class="uk-navbar-right">
      <ul class="uk-navbar-nav uk-visible@s">
        @unless (Auth::guest())
          <li><a class="uk-light" href="/logout" data-method="POST" uk-icon="icon: sign-out"></a></li>
        @endif
        <li><a class="uk-light" href="/" target="_blank" uk-icon="icon: home"></a></li>
      </ul>
    </div>
  </nav>
</div>
