<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($affiliate) ? '' : route('affiliates.store') }}" uk-grid>
  {{ csrf_field() }}

  {{-- @if (isset($coupon))
    <input type="hidden" name="_method" value="put"> --}}
{{-- @endif --}}
  <input type="hidden" name="status_affiliate" value="1">
  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="affiliate_id" class="uk-form-label">Cliente</label>
    <div class="uk-form-controls">
      <select name="user_id" class="uk-select{{ $errors->has('user_id') ? ' uk-form-danger' : '' }}">
        <option value="0">Seleccione un cliente</option>
        @foreach ($clients as $client)
          <option value="{{$client->user_id}}"
            @if (isset($affiliate))
              @if ($affiliate->user_id == $client->user_id)
                selected
              @endif
            @endif
          >{{$client->user->last_name}}, {{$client->user->first_name}}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="dni" class="uk-form-label">DNI</label>
    <div class="uk-form-controls">
      <input name="dni" type="number" value="{{ old('dni', isset($affiliate) ? $affiliate->dni : '') }}" class="uk-input{{ $errors->has('dni') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('dni'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('dni') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="facebook" class="uk-form-label">Facebook</label>
    <div class="uk-form-controls">
      <input name="facebook" type="text" value="{{ old('facebook', isset($affiliate) ? $affiliate->facebook : '') }}" class="uk-input{{ $errors->has('facebook') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('facebook'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('facebook') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="instagram" class="uk-form-label">Instagram</label>
    <div class="uk-form-controls">
      <input name="instagram" type="text" value="{{ old('instagram', isset($affiliate) ? $affiliate->instagram : '') }}" class="uk-input{{ $errors->has('instagram') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('instagram'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('instagram') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="facebook" class="uk-form-label">Twitter</label>
    <div class="uk-form-controls">
      <input name="twitter" type="text" value="{{ old('twitter', isset($affiliate) ? $affiliate->twitter : '') }}" class="uk-input{{ $errors->has('twitter') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('twitter'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('twitter') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="youtube" class="uk-form-label">Youtube</label>
    <div class="uk-form-controls">
      <input name="youtube" type="text" value="{{ old('youtube', isset($affiliate) ? $affiliate->youtube : '') }}" class="uk-input{{ $errors->has('youtube') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('youtube'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('youtube') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1@m uk-margin uk-flex-middle ">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
      <a class="uk-button uk-button-default" href="{{ route('affiliates.index') }}">REGRESAR</a>
    </div>
  </div>

</form>
