@extends('layouts.admin')

@section('content')

  <div class="uk-width-large uk-margin-auto">
    <div class="uk-card uk-card-body uk-card-default uk-background-muted">
      <form method="POST" action="{{ url('/password/reset') }}">
        {{ csrf_field() }}
        <fieldset class="uk-fieldset">
          <legend class="uk-legend uk-text-center">Recuperar contraseña</legend>
          <input type="hidden" name="token" value="{{ $token }}">
          <div class="uk-margin">
            <div class="uk-inline uk-width-1-1">
              <span class="uk-form-icon" uk-icon="icon: user"></span>
              <input id="email" type="email" class="uk-input" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>
              @if ($errors->has('email'))
                <span class="uk-text-danger">
                  <strong>Correo inválido</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="uk-margin">
            <div class="uk-inline uk-width-1-1">
              <span class="uk-form-icon" uk-icon="icon: lock"></span>
              <input id="password" type="password" class="uk-input" name="password" placeholder="Contraseña" minlength="6" required>
              @if ($errors->has('password'))
                <span class="uk-text-danger">
                </span>
              @endif
            </div>
          </div>

          <div class="uk-margin">
            <div class="uk-inline uk-width-1-1">
              <span class="uk-form-icon" uk-icon="icon: lock"></span>
              <input id="password-confirm" type="password" class="uk-input" name="password_confirmation" placeholder="Confirmar contraseña" minlength="6" required>
              @if ($errors->has('password_confirmation'))
                <span class="uk-text-danger">
                </span>
              @endif
            </div>
          </div>

          <div class="uk-margin">
            @if (session('status'))
              <div class="uk-text-success uk-text-center">
                Clave recuperada
              </div>
            @endif
          </div>

          <div class="uk-margin">
            <button type="submit" class="uk-button uk-background-primary uk-light uk-width-1-1">Confirmar</button>
          </div>

        </fieldset>
      </form>
    </div>
  </div>

@endsection
