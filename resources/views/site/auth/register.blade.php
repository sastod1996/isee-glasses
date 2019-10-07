@push('css')
  <link rel="stylesheet" href="/css/site/pages/auth.css">
@endpush

@extends('layouts.site')

@section('content')

  <div class="uk-section uk-background-cover uk-background-default">
    <div class="uk-section-small uk-padding-remove-bottom">
      <div class="uk-container uk-container-small">
        <div class="uk-h1 uk-text-center isee-bold isee-spacing-small">
          @lang('register.titulo')
        </div>
      </div>
    </div>
  </div>

  {{-- Show changes in register - @LuceroL --}}
  <div class="uk-section uk-padding-remove-top uk-margin">
    <div class="uk-container">
      <div class="" uk-grid>
        <div class="uk-width-expand"></div>
        <div class="uk-width-4-5@m uk-width-1-1">
          <div class="">
            <div class="uk-padding-small isee-background-gray">
              <div class="uk-flex uk-flex-center isee-h3 uk-text-center isee-bold">@lang('register.descripcion')</div>
            </div>
            <div class="uk-padding isee-border-not-top">
              <form class="uk-grid-small" method="POST" action="{{ route('register') }}" uk-grid>
                {{ csrf_field() }}
                <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large" type="text" name="first_name" placeholder="@lang('forms.nombres')" value="{{ old('first_name') }}" required>
                </div>
                <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large" type="text" name="last_name" placeholder="@lang('forms.apellidos')" value="{{ old('last_name') }}" required>
                </div>
                <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large" type="number" name="dni" placeholder="@lang('forms.dni')" value="{{ old('dni') }}" required max="9999999999">
                </div>
                <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large" type="email" name="email" placeholder="@lang('forms.correo')" value="{{ old('email') }}" required>
                </div>
                <div class="uk-width-1-2@s">
                  <input id="telephone" class="uk-input uk-form-large" type="tel" name="telephone" placeholder="@lang('forms.tlf') / @lang('forms.cel')" value="{{ old('telephone') }}"  maxlength="9" required>
                </div>
                {{-- <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large" type="text" name="country" placeholder="País">
                </div>
                <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large" type="text" name="city" placeholder="Ciudad">
                </div> --}}

                <div class="uk-width-1-2@s uk-width-1-1">
                  <select class="uk-select uk-form-large crs-country" data-show-default-option="false" data-default-value="Peru" data-region-id="city" id="country" name="country" value="{{ isset($user) ? $user->country : '' }}">
                  </select>
                  {{-- <select id="country" class="uk-input uk-form-large" type="text" name="country" value="{{ isset($user) ? $user->country : '' }}" placeholder="País"> --}}
                </div>
                <div class="uk-width-1-2@s uk-width-1-1">
                  <select class="uk-select uk-form-large" id="city" name="city" data-show-default-option data-default-value="Lima" value="{{ isset($user) ? $user->city : '' }}">
                  </select>
                  {{-- <select id="country" class="uk-input uk-form-large" type="text" name="country" value="{{ isset($user) ? $user->country : '' }}" placeholder="País"> --}}
                </div>
                <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large uk-hidden" id="input-district" type="text" name="district" value="{{ old('district', isset($user->client->district) ? $user->client->district : '') }}" placeholder="@lang('forms.distrito')">
                  <select class="uk-select uk-form-large" id="select-district" name="district"  value="{{ old('district',isset($user->client->district) ? $user->client->district : '') }}">
                    <option disabled value="">Seleccionar distrito</option>
                    @foreach ($districts as $district)
                      <option value="{{ $district->value }}"
                        @if (isset($user->client->district))
                          @if ($district->value == $user->client->district)
                            selected
                          @endif
                        @endif
                      >{{ $district->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large" type="text" name="code" placeholder="@lang('forms.cod-postal')">
                </div>
                <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large" type="text" name="address" placeholder="@lang('forms.direccion')">
                </div>
                <div class="uk-width-1-2@s">
                  <input class="uk-input uk-form-large" type="text" name="reference" placeholder="@lang('forms.referencia')">
                </div>
                <input type="hidden" name="role_id" value="2">

                <input type="hidden" name="rate_id" value="1">

                <div class="uk-width-1-2@s">
                  <input id="pass" class="uk-input uk-form-large" type="password" name="password" placeholder="@lang('forms.password')" min="6" required>
                </div>
                <div class="uk-width-1-2@s">
                  <input id="password-confirmation" class="uk-input uk-form-large" type="password" name="password_confirmation" placeholder="@lang('forms.repetir-password')" min="6" required>
                </div>
                <div class="uk-width-1-1">
                  <label>
                    <input id="terms" class="uk-checkbox" type="checkbox"><span class="isee-color-gray uk-margin-small-left">@lang('register.mensaje1') <a href="#" uk-toggle="target: #terminos">@lang('register.mensaje2')</a></span><br>
                  </label>
                </div>
                <div class="uk-margin-auto">
                  <button id="enviar" class="isee-h3 uk-button uk-button-large uk-light isee-bold isee-background-green" type="submit">@lang('register.boton')</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="uk-width-expand"></div>
      </div>
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
  var check_pass = false;

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

  // var password = $('#password')
  // var confirm_password = $('#password-confirmation')

  function validatePassword(){
    if($('#pass').val() != $('#password-confirmation').val()) {
      return false;
    } else {
      return true;
    }
  }

  $("#enviar").on('click',function(){
    if($("#terms").is(':checked')) {
      if (! validatePassword()) {
        UIkit.notification({
          message: 'Las contraseñas no coinciden ',
          status: 'danger',
          pos: 'top-center',
          timeout: 5000
        });
        return false;
      }
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

@push('js')
  <script>
    //
    // $('#select-district option').each( function(){
    //   console.log(this);
    //   }
    // );

    $(document).ready(function() {
      $('#select-district').val($('#input-district').val());
      showDistricts();
    });

    $('#city').change(function(){
      showDistricts()
    });

    $('#country').change(function(){
      showInput()
    });

    function showDistricts() {
      if ($('#city').val() != 'Lima') {
        showInput()
      }else {
        showSelect()
      }
    }

    function showInput(){
      $('#select-district').addClass("uk-hidden")
      $('#select-district').removeAttr("name")
      $('#input-district').removeClass("uk-hidden")
      $('#input-district').attr("name", 'district')
    }

    function showSelect(){
      $('#select-district').removeClass("uk-hidden")
      $('#select-district').attr("name", 'district')
      $('select option[value="0"]').attr("selected",true);
      $('#input-district').addClass("uk-hidden")
      $('#input-district').removeAttr("name")
      $('#input-district').val("")
    }

  </script>
@endpush
