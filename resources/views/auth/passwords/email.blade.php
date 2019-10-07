@extends('layouts.admin')

@section('content')

  <div class="uk-width-large uk-margin-auto">
    <div class="uk-card uk-card-body uk-card-default uk-background-muted">
      <form method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
        <fieldset class="uk-fieldset">
          <legend class="uk-legend uk-text-center">Recuperar contraseña</legend>

          <div class="uk-margin">
            <div class="uk-inline uk-width-1-1">
              <span class="uk-form-icon" uk-icon="icon: user"></span>
              <input type="email" class="uk-input" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>
              @if ($errors->has('email'))
                <span class="uk-text-danger">
                  Correo inválido
                </span>
              @endif
            </div>
          </div>

          <div class="uk-margin">
            @if (session('status'))
              <div class="uk-text-success uk-text-center">
                Correo enviado
              </div>
            @endif
          </div>

          <div class="uk-margin">
            <button type="submit" class="uk-button uk-background-primary uk-light uk-width-1-1">Enviar</button>
          </div>

        </fieldset>
      </form>
    </div>
  </div>

@endsection
