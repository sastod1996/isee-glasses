<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($user) ? route('clients.update', ['id' => $user->id]) : route('clients.store') }}" enctype="multipart/form-data" uk-grid>
  {{ csrf_field() }}

  @if (isset($user))
    <input type="hidden" name="_method" value="put">
    <input type="hidden" name="backTo" value="{{ isset($backTo) ? $backTo : ''}}">
  @endif

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('first_name') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="first_name">Nombres</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="first_name" name="first_name" type="text" value="{{ old('first_name', isset($user) ? $user->first_name : '') }}">
      @if ($errors->has('first_name'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('first_name') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('last_name') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="last_name">Apellidos</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="last_name" name="last_name" type="text" value="{{ old('last_name', isset($user) ? $user->last_name : '') }}">
      @if ($errors->has('last_name'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('last_name') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('email') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="email">Correo</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="email" name="email" type="email" value="{{ old('email', isset($user) ? $user->email : '') }}"
        @if (isset($user))
          disabled
        @endif
      >
      @if ($errors->has('email'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('email') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('telephone') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="telephone">Teléfono</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="telephone" name="telephone" type="text" value="{{ old('telephone', isset($user) ? $user->telephone : '') }}">
      @if ($errors->has('telephone'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('telephone') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('password') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="password">Contraseña</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="password" name="password" type="password">
      @if ($errors->has('password'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('password') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('enterprise_id') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="enterprise_id">Empresa</label>
    <div class="uk-form-controls">
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
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('country') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="country">País</label>
    <div class="uk-form-controls">
      <select class="uk-select crs-country" data-show-default-option="false" data-default-value={{ isset($user->client->country) ? $user->client->country : 'Peru' }} data-region-id="city" id="country" name="country">
      </select>
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('city') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="city">Ciudad</label>
    <div class="uk-form-controls">
      <select class="uk-select" id="city" name="city" data-show-default-option data-default-value={{isset($user->client->city) ? $user->client->city : 'Lima'}}>
      </select>
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('district') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="district">Distrito</label>
    <div class="uk-form-controls">
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
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('code') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="code">Código</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="code" name="code" type="text" value="{{ old('code', isset($user->client->code) ? $user->client->code : '') }}">
      @if ($errors->has('code'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('code') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('address') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="address">Dirección</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="address" name="address" type="text" value="{{ old('address', isset($user->client->address) ? $user->client->address : '') }}">
      @if ($errors->has('address'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('address') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin {{ $errors->has('reference') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="reference">Referencia</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="reference" name="reference" type="text" value="{{ old('reference', isset($user->client->reference) ? $user->client->reference : '') }}">
      @if ($errors->has('reference'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('reference') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="ally" class="uk-form-label">Estado</label>
    <div class="uk-form-controls">
      <select name="ally" id="ally" class="uk-select{{ $errors->has('ally') ? ' uk-form-danger' : '' }}">
        <option value="1"
          @if (isset($user->client))
            @if ($user->client->ally)
              selected
            @endif
          @endif
        >Activo</option>
        <option value="0"
          @if (isset($user->client))
            @if (!$user->client->ally)
              selected
            @endif
          @endif
        >Inactivo</option>
      </select>
    </div>
  </div>

  {{-- <div class="uk-width-1-1@s">
    <a class="uk-link-text isee-h5 isee-color uk-text-bold" href="#update-password" uk-toggle>Cambiar contraseña</a>
  </div> --}}

  <div class="uk-width-1-1 uk-margin">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
      <a class="uk-button uk-button-default" href="{{ isset($backTo) ? url($backTo) : route('clients.index') }}">REGRESAR</a>
    </div>
  </div>

</form>

@push('js')
  <script>
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
