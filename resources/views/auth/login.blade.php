@extends('layouts.admin')

@section('content')

  <div class="uk-width-large uk-margin-auto">
    <div class="uk-card uk-card-body uk-card-default uk-background-muted">
      <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <fieldset class="uk-fieldset">
          <legend class="uk-legend uk-text-center">Iniciar sesión</legend>

          <div class="uk-margin">
            <div class="uk-inline uk-width-1-1">
              <span class="uk-form-icon" uk-icon="icon: user"></span>
              <input type="email" class="uk-input" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>
            </div>
          </div>

          <div class="uk-margin">
            <div class="uk-inline uk-width-1-1">
              <span class="uk-form-icon" uk-icon="icon: lock"></span>
              <input type="password" class="uk-input" name="password" placeholder="Contraseña" minlength="6" required>
            </div>
          </div>

          <div class="uk-margin">
            <button type="submit" class="uk-button uk-background-primary uk-light uk-width-1-1">Acceder</button>
          </div>

          <div class="uk-margin uk-hidden">
            <label>
              <input type="checkbox" name="remember" class="uk-checkbox" {{ old('remember') ? 'checked' : ''}}> Recordarme
            </label>
          </div>
        </fieldset>

        <div class="uk-text-center">
          <a class="" href="{{ route('password.request') }}">
            ¿Olvidaste tu contraseña?
          </a>
        </div>
      </form>
    </div>
  </div>

@endsection
