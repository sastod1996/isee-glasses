@push('css')
  <link rel="stylesheet" href="/css/site/pages/auth.css">
@endpush

@extends('layouts.admin')

@section('content')

  <div class="uk-width-2-3 uk-margin-auto">
    <div class="uk-card uk-card-body uk-card-default uk-background-muted">
      <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <fieldset class="uk-fieldset">
          <legend class="uk-legend uk-text-center">@lang('register.titulo')</legend>

          <div class="uk-margin uk-grid-small" uk-grid>
            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="text" class="uk-input" name="first_name" value="{{ old('first_name') }}" placeholder="@lang('forms.nombres')" required autofocus>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="text" class="uk-input" name="last_name" value="{{ old('last_name') }}" placeholder="@lang('forms.apellidos')" required autofocus>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="email" class="uk-input" name="email" value="{{ old('email') }}" placeholder="@lang('forms.correo')" required autofocus>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="tel" class="uk-input" name="telephone" value="{{ old('telephone') }}" placeholder="@lang('forms.tlf') / @lang('forms.cel')" maxlength="9" required autofocus>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="text" class="uk-input" name="country" value="{{ old('country') }}" placeholder="País" required autofocus>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="text" class="uk-input" name="city" value="{{ old('city') }}" placeholder="Ciudad" required autofocus>
              </div>
            </div>

            {{-- <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <select class="uk-select crs-country" data-show-default-option="false" data-default-value="Peru" data-region-id="city" id="country" name="country" value="{{ isset($user) ? $user->country : '' }}"></select>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <select class="uk-select" id="city" name="city" data-show-default-option data-default-value="Lima" value="{{ isset($user) ? $user->city : '' }}"></select>
              </div>
            </div> --}}

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="text" class="uk-input" name="code" value="{{ old('code') }}" placeholder="@lang('forms.cod-postal')" required autofocus>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="text" class="uk-input" name="district" value="{{ old('district') }}" placeholder="@lang('forms.distrito')" required autofocus>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="text" class="uk-input" name="address" value="{{ old('address') }}" placeholder="@lang('forms.direccion')" required autofocus>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="text" class="uk-input" name="reference" value="{{ old('reference') }}" placeholder="@lang('forms.referencia')" required autofocus>
              </div>
            </div>

            <input type="hidden" name="role_id" value="2">
            <input type="hidden" name="rate_id" value="1">

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="password" class="uk-input" name="password" placeholder="@lang('forms.password')" minlength="6" required>
              </div>
            </div>

            <div class="uk-width-1-2@s uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <input type="password" class="uk-input" name="password_confirmation" placeholder="@lang('forms.repetir-password')" minlength="6" required>
              </div>
            </div>

            <div class="uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <label>
                  <input id="terms" class="uk-checkbox" type="checkbox"><span class="isee-color-gray uk-margin-small-left">@lang('register.mensaje1') <a href="#" uk-toggle="target: #terminos">@lang('register.mensaje2')</a></span><br>
                </label>
              </div>
            </div>

            <div class="uk-width-1-1">
              <div class="uk-inline uk-width-1-1">
                <button type="submit" class="uk-button uk-background-primary uk-light uk-width-1-1">@lang('register.boton')</button>
              </div>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>

  {{-- MODAL --}}
  <div id="terminos" uk-modal>
    <div class="uk-modal-dialog uk-width-2-3@m uk-width-1-1 uk-background-primary">
      <button class="uk-modal-close-default" type="button" uk-close></button>
      <div class="uk-modal-body isee-modal-body">
        <div class="uk-text-center uk-padding uk-padding-remove-bottom">
          <p class="uk-h2 uk-text-bold uk-light">@lang('terms.terms')</p>
        </div>
        <div class="uk-padding-medium uk-background-default">
          <div class="uk-padding">
            <div class="">
              <div class="uk-h4 uk-text-bold">@lang('terms.titulo1')</div>
              <p class="uk-text-justify">
                @lang('terms.desc1')
              </p>
            </div>
            <div class="">
              <div class="uk-h4 uk-text-bold">@lang('terms.titulo2')</div>
              <p class="uk-text-justify">
                @lang('terms.desc2')
              </p>
            </div>
            <div class="">
              <div class="uk-h4 uk-text-bold">@lang('terms.titulo3')</div>
              <p>
                @lang('terms.desc3')
              </p>
            </div>
            <div class="">
              <div class="uk-h4 uk-text-bold">@lang('terms.titulo4')</div>
              <p>
                @lang('terms.desc4')
              </p>
            </div>
            <div class="">
              <div class="uk-h4 uk-text-bold">@lang('terms.titulo5')</div>
              <p>
                @lang('terms.desc5')
              </p>
            </div>
          </div>
        </div>
        <div class="uk-text-center uk-padding">
          <input class="uk-checkbox" type="checkbox"><span class="uk-light uk-text-bold uk-margin-small-left">@lang('terms.acepto')</span><br>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('js')
  <script>
  $(document).ready(function() {
    $("#telephone").keydown(function (e) {
      // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
      // Allow: Ctrl+A, Command+A
      (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
      // Allow: home, end, left, right, down, up
      (e.keyCode >= 35 && e.keyCode <= 40)) {
        // let it happen, don't do anything
        return;
      }
      // Ensure that it is a number and stop the keypress
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
      }
    });
  });

  $("#enviar").on('click',function(){
    if($("#terms").is(':checked')) {
        // return true;
    } else {
      UIkit.notification({
        message: 'Debe aceptar los términos y condiciones',
        status: 'danger',
        pos: 'top-center',
        timeout: 5000
      });
      return false;
    }
  });

// function validatePassword(){
//   var password = $('#password').val();
//   var confirm_password = $('#password-confirmation').val();
//   if(password == confirm_password) {
//     return true;
//   } else {
//     return false;
//   }
// }
  </script>
@endpush
