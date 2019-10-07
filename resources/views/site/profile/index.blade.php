@extends('site.partials.navbar')

@section('navbar')

  <div id="profile" class="uk-section uk-section-small">
    <div class="uk-container uk-container-small">
      <div class="uk-h2 uk-text-center isee-bold isee-spacing-small">
        @lang('profile.perfil')
      </div>
      <form class="uk-form-stacked uk-grid-small" method="POST" action="{{route('profile.update', ['id' => $user->id])}}" uk-grid>
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="uk-width-1-2@s">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="first_name">@lang('forms.nombres')</label>
          <input class="uk-input" type="text" id="first_name" name="first_name" placeholder="@lang('forms.nombres')" value="{{ old('first_name', isset($user->first_name) ? $user->first_name : '')}}" required>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="last-name">@lang('forms.apellidos')</label>
          <input class="uk-input" type="text" id="last-name" name="last_name" placeholder="@lang('forms.apellidos')" value="{{ old('last_name', isset($user->last_name) ? $user->last_name : '') }}" required>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="email">@lang('forms.correo')</label>
          <input class="uk-input" type="email" id="email" name="email" placeholder="@lang('forms.correo')" value="{{ old('email', isset($user->email) ? $user->email : '') }}" disabled required>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="telephone">@lang('forms.tlf') / @lang('forms.cel')</label>
          <input id="telephone" class="uk-input" type="tel" id="telephone" name="telephone" value="{{ old('telephone', isset($user->telephone) ? $user->telephone : '') }}"  maxlength="9">
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold">Empresa</label>
          <select class="uk-select" name="enterprise_id" value="{{ old('enterprise_id',isset($user->client->enterprise) ? $user->client->enterprise->id : '') }}">
            <option value="" disabled selected>Seleccionar empresa</option>
            @foreach ($enterprises as $enterprise)
              <option value="{{ $enterprise->id }}"
                @if (isset($user->client->enterprise))
                  @if ($enterprise->id === $user->client->enterprise->id)
                    selected
                  @endif
                @endif
              >{{ $enterprise->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="uk-width-1-2@s uk-width-1-1">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="country">@lang('forms.pais')</label>
          <select class="uk-select crs-country" data-show-default-option="false" data-default-value={{ isset($user->client->country) ? $user->client->country : 'Peru' }} data-region-id="city" id="country" name="country">
          </select>
        </div>
        <div class="uk-width-1-2@s uk-width-1-1">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="city">@lang('forms.city')</label>
          <select class="uk-select" id="city" name="city" data-show-default-option data-default-value={{isset($user->client->city) ? $user->client->city : 'Lima'}}>
          </select>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="input-district">@lang('forms.distrito')</label>
          <input class="uk-input uk-hidden" id="input-district" type="text" name="district" value="{{ old('district', isset($user->client->district) ? $user->client->district : '') }}" placeholder="@lang('forms.distrito')">
          <select class="uk-select" id="select-district" name="district"  value="{{ old('district',isset($user->client->district) ? $user->client->district : '') }}">
            <option disabled value="">Seleccionar distrito</option>
            @foreach ($districts as $district)
              <option value="{{ $district->value }}"
                @if (isset($user->client->district))
                  @if ($district->name === $user->client->district)
                    selected
                  @endif
                @endif
              >{{ $district->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="code">@lang('forms.cod-postal')</label>
          <input class="uk-input" type="text" id="code" name="code" placeholder="@lang('forms.cod-postal')" value="{{old('code', isset($user->client->code) ? $user->client->code : '')}}">
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="address">@lang('forms.direccion')</label>
          <input class="uk-input" type="text" id="address" name="address" placeholder="@lang('forms.direccion')" value="{{old('address', isset($user->client->address) ? $user->client->address : '')}}">
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label isee-h5 isee-color uk-text-bold" for="reference">@lang('forms.referencia')</label>
          <input class="uk-input" type="text" id="reference" name="reference" name="reference" placeholder="@lang('forms.referencia')" value="{{old('reference', isset($user->client->reference) ? $user->client->reference : '')}}">
        </div>
        <div class="uk-width-1-1@s">
          <a class="uk-link-text isee-h5 isee-color uk-text-bold" href="#update-password" uk-toggle>Cambiar contraseña</a>
        </div>
        <div class="uk-margin-auto">
          <button class="isee-h3 uk-button uk-button-large uk-light isee-bold isee-background-green" type="submit">Actualizar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- This is the modal -->
  <div id="update-password" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
      <h2 class="uk-modal-title isee-color">Cambiar contraseña</h2>
      <form class="uk-form-horizontal" method="POST" action="{{ route('changePassword',['id' => $user->id]) }}">
        {{ csrf_field() }}
        <div class="uk-margin">
          <label class="uk-form-label isee-h5 isee-color" for="current-password">Contraseña actual</label>
          <div class="uk-form-controls">
            <input class="uk-input" id="current-password" name="password" type="password" placeholder="Contraseña actual" required>
          </div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label isee-h5 isee-color" for="new_password">Nueva contraseña</label>
          <div class="uk-form-controls">
            <input class="uk-input" id="new-password" name="new_password" type="password" placeholder="Nueva contraseña" required>
          </div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label isee-h5 isee-color" for="confirm_password">Confirmar contraseña</label>
          <div class="uk-form-controls">
            <input class="uk-input" id="confirm_password" name="confirm_password" type="password" placeholder="Confirmar contraseña" required>
          </div>
        </div>
        <p class="uk-text-right">
          <button class="uk-button uk-button-default uk-modal-close" type="button">CANCELAR</button>
          <button class="uk-button uk-background-primary uk-light" type="submit">CONFIRMAR</button>
        </p>
      </form>
    </div>
  </div>

@endsection

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

@push('js')
  @if (session('update_profile'))
    <script type="text/javascript">
      UIkit.notification({
        message: '<span uk-icon="icon: check"></span>Datos actualizados',
        status: 'primary',
        pos: 'bottom-center',
        timeout: 5000
      });
    </script>
  @endif

  @if (session('changePassword'))
    <script type="text/javascript">
      UIkit.notification({
        message: '<span uk-icon="icon: check"></span>Contraseña Actualizada',
        status: 'primary',
        pos: 'bottom-center',
        timeout: 5000
      });
    </script>
  @endif

  @if (session('errorPassword'))
    <script type="text/javascript">
      UIkit.notification({
        message: '<span uk-icon="icon: alert"></span>Contraseña errónea',
        status: 'danger',
        pos: 'bottom-center',
        timeout: 5000
      });
    </script>
  @endif

@endpush
