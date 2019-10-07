@extends('layouts.site')

@section('content')
  <div class="uk-section uk-background-cover uk-background-default">
    <div class="uk-section-small uk-padding-remove-bottom">
      <div class="uk-container uk-container-small">
        <div class="uk-h1 uk-text-center isee-bold isee-spacing-small">
          @lang('afiliacion.titulo')
        </div>
      </div>
    </div>
  </div>
  <div class="uk-section uk-padding-remove-top uk-margin">
    <div class="uk-container">
      <div class="" uk-grid>
        <div class="uk-width-expand"></div>
        <div class="uk-width-4-5@m uk-width-1-1">
          <div class="">
            <div class="uk-padding-small isee-background-gray">
              <div class="uk-flex uk-flex-center isee-h3 uk-text-center isee-bold">@lang('afiliacion.mensaje1')</div>
            </div>
            <div class="uk-padding isee-border-not-top">
              <form id="affiliate-form" class="uk-grid-small" method="POST" action="{{route('affiliate.store')}}" uk-grid>
                {{ csrf_field() }}
                @if (Session::has('status'))
                  <div class="uk-width-1-1@s">
                    <div class="uk-alert-success" uk-alert>
                      <a class="uk-alert-close" uk-close></a>
                      <p>{{Session::get('status')}}</p>
                    </div>
                  </div>
                @endif
                @if (Session::has('error'))
                  {{-- {{dd($errors->all())}} --}}
                  <div class="uk-width-1-1@s">
                    <div class="uk-alert-danger" uk-alert>
                      <a class="uk-alert-close" uk-close></a>
                      <p>
                        @foreach ($errors->all() as $error)
                          {{ $error }}
                        @endforeach
                      </p>
                    </div>
                  </div>
                @endif
                <input type="hidden" name="user_id" value="{{isset($user) ? $user->id : '0'}}">
                <input type="hidden" name="status_affiliate" value="0">
                <input type="hidden" name="rate_id" value="{{ isset($user) ? $user->rate_id : '1'}}">
                @if (!Auth::check())
                  <input type="hidden" name="role_id" value="2">
                  <div class="uk-width-1-2@s">
                    <input class="uk-input uk-form-large" type="text" name="first_name" placeholder="@lang('forms.nombres')" value="{{ old('first_name') }}">
                  </div>
                  <div class="uk-width-1-2@s">
                    <input class="uk-input uk-form-large" type="text" name="last_name" placeholder="@lang('forms.apellidos')" value="{{ old('last_name') }}">
                  </div>
                  <div class="uk-width-1-2@s">
                    <input class="uk-input uk-form-large" type="email" name="email" placeholder="@lang('forms.correo')" value="{{ old('email') }}">
                  </div>
                  <div class="uk-width-1-2@s">
                    <input id="telephone" class="uk-input uk-form-large" type="tel" name="telephone" placeholder="@lang('forms.tlf') / @lang('forms.cel')" value="{{ old('telephone') }}"  maxlength="9">
                  </div>
                  <div class="uk-width-1-2@s uk-width-1-1">
                    <select class="uk-select uk-form-large crs-country" data-show-default-option="false" data-default-value="Peru" data-region-id="city" id="country" name="country" value="{{ isset($user) ? $user->country : '' }}">
                    </select>
                  </div>
                  <div class="uk-width-1-2@s uk-width-1-1">
                    <select class="uk-select uk-form-large" id="city" name="city" data-show-default-option data-default-value="Lima" value="{{ isset($user) ? $user->city : '' }}">
                    </select>
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
                @endif
                  <div class="uk-width-1-2@s">
                    <input class="uk-input uk-form-large" type="text" id="dni" name="dni" placeholder="DNI" value="{{ old('dni') }}" maxlength="10">
                  </div>
                  <div class="uk-width-1-2@s">
                    <input class="uk-input uk-form-large" type="text" name="facebook" placeholder="Facebook" value="{{ old('facebook') }}" maxlength="100">
                  </div>
                  <div class="uk-width-1-2@s">
                    <input class="uk-input uk-form-large" type="text" name="instagram" placeholder="Instagram" value="{{ old('instagram') }}" maxlength="100">
                  </div>
                  <div class="uk-width-1-2@s">
                    <input class="uk-input uk-form-large" type="text" name="twitter" placeholder="Twitter" value="{{ old('twitter') }}" maxlength="100">
                  </div>
                  <div class="uk-width-1-2@s">
                    <input class="uk-input uk-form-large" type="text" name="youtube" placeholder="Youtube" value="{{ old('youtube') }}" maxlength="100">
                  </div>
                @if (!Auth::check())
                  <div class="uk-width-1-2@s">
                    <input id="pass" class="uk-input uk-form-large" type="password" name="password" placeholder="@lang('forms.password')" min="6">
                  </div>
                  <div class="uk-width-1-2@s">
                    <input id="password-confirmation" class="uk-input uk-form-large" type="password" name="password_confirmation" placeholder="@lang('forms.repetir-password')" min="6">
                  </div>
                @endif
                <div class="uk-width-1-1">
                  <label>
                    <input id="check-terms" class="uk-checkbox" type="checkbox"><span class="uk-margin-small-left">Acepto los <a href="#" class="uk-text-bold uk-link-reset" uk-toggle="target: #afiliacion-modal">términos y condiciones</a></span><br>
                  </label>
                </div>
                <div class="uk-width-1-1 uk-margin-auto uk-text-center">
                  <button id="send" class="isee-h3 uk-button uk-button-large uk-light isee-bold isee-background-green" type="button">Enviar solicitud de afiliación</button>
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
  <div id="afiliacion-modal" uk-modal>
    <div class="uk-modal-dialog uk-width-2-3@m uk-width-1-1 uk-background-primary">
      <button class="uk-modal-close-default" type="button" uk-close></button>
      <div class="uk-modal-body isee-modal-body">
        <div class="uk-text-center uk-padding uk-padding-remove-bottom">
          <p class="uk-h2 uk-text-bold uk-light">@lang('afiliacion-terms.terms')</p>
        </div>
        <div class="uk-padding-medium uk-background-default">
          <div class="uk-padding">
            <div class="">
              <div class="uk-h4 uk-text-bold">@lang('afiliacion-terms.restricciones')</div>
              <ul class="uk-list">
                <li>
                  @lang('afiliacion-terms.restricciones1')
                </li>
              </ul>
            </div>
            <div class="">
              <div class="uk-h4 uk-text-bold">@lang('afiliacion-terms.comisiones')</div>
              <ul class="uk-list uk-text-justify">
                <li>
                  @lang('afiliacion-terms.comisiones1')
                </li>
                <li>
                  @lang('afiliacion-terms.comisiones2')
                </li>
                <li>
                  @lang('afiliacion-terms.comisiones3')
                </li>
                <li>
                  @lang('afiliacion-terms.comisiones4')
                </li>
                <li>
                  @lang('afiliacion-terms.comisiones5')
                </li>
              </ul>
            </div>
            <div class="">
              <div class="uk-h4 uk-text-bold">@lang('afiliacion-terms.aceptacion')</div>
              <ul class="uk-list">
                <li>
                  @lang('afiliacion-terms.aceptacion1')
                </li>
                <li>
                  @lang('afiliacion-terms.aceptacion2')
                </li>
              </ul>
            </div>
          </div>
        </div>
        {{-- <div class="uk-text-center uk-padding">
          <label>
            <input id="check-terms" class="uk-checkbox" type="checkbox"><span class="uk-light uk-text-bold uk-margin-small-left">@lang('afiliacion-terms.acepto')</span><br>
          </label>
        </div> --}}
        {{-- <div class="uk-text-center">
          <a class="isee-h4 uk-button uk-button-large uk-light isee-bold isee-background-green">@lang('afiliacion-terms.afiliarme')</a>
          <a class="isee-h4 uk-button uk-button-large uk-light isee-bold isee-background-green" href="/afiliarme">@lang('afiliacion-terms.afiliarme')</a>
        </div> --}}
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $('#send').on('click', function(){
      if(! $("#check-terms").is(':checked')){
        UIkit.notification({
          message: 'Debe aceptar los términos y condiciones',
          status: 'danger',
          pos: 'bottom-center',
          timeout: 5000
        });
      }else{
        $('#affiliate-form').submit()
      }
    });

    $(document).ready(function() {
      $("#dni").keydown(function (e) {
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
  </script>
@endpush
