<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($order) ? route('orders.update', ['id' => $order->id]) : route('orders.store') }}">

  {{ csrf_field() }}

  @if (isset($order))
    <input type="hidden" name="_method" value="put">
  @endif

  <input type="hidden" name="type" value="{{ $type }}">

  <div class="uk-width-1-1 uk-margin {{ $errors->has('code') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="code">Código de rastreo</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="code" name="code" type="text" value="{{ old('code', isset($order) ? $order->code : '') }}" maxlength="45">
      @if ($errors->has('code'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('code') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin {{ $errors->has('client_id') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="client_id">Cliente</label>
    <div class="uk-form-controls">
      @if (isset($order))
        @php
          $client = \App\Client::where('user_id', '=', $order->client_id)->first();
        @endphp
        <input class="uk-input" id="client_id" name="client_id" type="text" value="{{ old('client_id', isset($order->client_id) ? $client->user->first_name.' '.$client->user->last_name : '') }}" disabled>
      @else
        <select id="client_id" class="uk-select" name="client_id">
          @foreach ($clients as $client)
            <option class="" value="">{{ $client->user->first_name.' '.$client->user->last_name }}</option>
          @endforeach
        </select>
      @endif
      @if ($errors->has('client_id'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('client_id') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin {{ $errors->has('country') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="country">País</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="country" name="country" type="text" value="{{ old('country', isset($order) ? $order->country : '') }}" maxlength="30">
      @if ($errors->has('country'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('country') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin {{ $errors->has('city') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="city">Ciudad</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="city" name="city" type="text" value="{{ old('city', isset($order) ? $order->city : '') }}" maxlength="30">
      @if ($errors->has('city'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('city') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin {{ $errors->has('district') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="city">Distrito</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="district" name="district" type="text" value="{{ old('district', isset($order) ? $order->district : '') }}" maxlength="30">
      @if ($errors->has('district'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('district') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin {{ $errors->has('address') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="address">Dirección de envío</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="address" name="address" type="text" value="{{ old('address', isset($order) ? $order->address : '') }}" maxlength="100">
      @if ($errors->has('address'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('address') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin {{ $errors->has('reference') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="reference">Referencia</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="reference" name="reference" type="text" value="{{ old('reference', isset($order) ? $order->reference : '') }}" maxlength="100">
      @if ($errors->has('reference'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('reference') }}</strong>
        </p>
      @endif
    </div>
  </div>


  <div class="uk-width-1-1 uk-margin {{ $errors->has('state_id') ? ' has-error' : '' }}">
    <label class="uk-form-label" for="state_id">Estado actual
    </label>
    <div class="uk-form-controls">
      <select class="uk-select" id="state_id" name="state_id">
        <option selected disabled>Seleccionar Estado</option>
        @foreach ($states as $state)
          @if ($order->getcurrentState()->id == $state->id)
            <option selected value="{{$state->id}}">{{$state->name}}</option>
          @elseif ($order->getcurrentState()->id < $state->id)
            <option value="{{$state->id}}">{{$state->name}}</option>
          @endif
        @endforeach
      </select>
      @if ($errors->has('state_id'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('state_id') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
      <a class="uk-button uk-button-default" href="{{ route('orders.indexbyStatus', ['type' => $type]) }}">REGRESAR</a>
    </div>
  </div>
</form>
