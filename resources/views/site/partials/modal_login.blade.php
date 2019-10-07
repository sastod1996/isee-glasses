<div id="modal-login" class="uk-modal-container" uk-modal>
  <div class="uk-modal-dialog">
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <div class="uk-modal-body uk-background-primary">
      <div class="isee-padding-small">
        <div class="uk-child-width-1-2@m uk-child-width-1-1 uk-grid-collapse" uk-grid>
          <div class="">
            <div class="uk-light">
              <p>
                <span uk-icon="icon: user; ratio: 1.2"></span>
                <span class="uk-text-bold isee-h3">@lang('nav.mi-cuenta')</span>
              </p>
            </div>
            <div class="">
              <form class="uk-form login-form" method="post" action="">
                {{ csrf_field() }}
                <div class="uk-margin">
                  <input id="email-modal" class="uk-input uk-form-large" style="font-size: 1rem;" type="email" name="email" placeholder="@lang('nav.correo')">
                </div>
                <div class="uk-margin">
                  <input id="password" class="uk-input uk-form-large" style="font-size: 1rem;" type="password" name="password" value="" placeholder="@lang('nav.password')">
                </div>
                <div id="error" class="uk-margin uk-text-danger uk-text-bold uk-hidden">
                  <span uk-icon="icon: warning"></span>  @lang('nav.error')
                </div>
                <div class="uk-margin">
                  <label class="uk-visible@s"><input class="uk-checkbox" type="checkbox"><span class="uk-light uk-text-bold"> @lang('nav.recuerdame')</span></label>
                  <span><a class="uk-light" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a></span>
                </div>
                <div class="uk-visible@s uk-margin uk-flex uk-flex-space-between">
                  <button class="uk-align-center uk-button uk-light isee-background-green button-submit isee-h5" type="submit" name="button">@lang('nav.login')</button>
                  <div style="width:30px;">
                    <span uk-spinner="" class="uk-spinner uk-icon uk-light login" style="display:none;"></span>
                  </div>
                </div>
                <div class="uk-hidden@s uk-margin">
                  <div class="uk-text-center">
                    <div class="uk-margin">
                      <button class="uk-button uk-light isee-background-green button-submit isee-h5" type="submit" name="button">@lang('nav.login')</button>
                    </div>
                    <div class="uk-light">
                      @lang('nav.mensaje')
                    </div>
                    <div class="uk-margin">
                      <a class="uk-button uk-light isee-background-green button-submit isee-h5" href="/registrar">@lang('nav.crear-cuenta')</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="uk-visible@s uk-light uk-text-center uk-text-bold">
            <div class="">
              <p class="isee-h3">@lang('nav.no-registrado')</p>
              <p class="isee-h5 uk-width-2-3 uk-margin-auto uk-text-justify">
                @lang('nav.mensaje')
              </p>
              <p>
                <a class="uk-button isee-background-green uk-width-1-2@s uk-width-1-1 isee-h5" href="/registrar">@lang('nav.crear-cuenta')</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
