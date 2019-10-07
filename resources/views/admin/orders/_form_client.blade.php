<form class="form-horizontal" method="POST" action="{{ isset($order) ? route('orders.update', ['id' => $order->id]) : route('orders.store') }}">

  {{ csrf_field() }}

  @if (isset($order))
    <input type="hidden" name="_method" value="put">
    <input type="hidden" name="code" value="{{ $order->code }}">
  @else
    <input type="hidden" name="code" value="{{ getCode('App\Order') }}">
  @endif

  <input type="hidden" name="client_id" value="{{ Auth::id() }}">

  <div class="form-group{{ $errors->has('prescription_id') ? ' has-error' : '' }}">
    <label for="prescription_id" class="col-md-3 control-label">Receta médica</label>
    <div class="col-md-9">
      <select name="prescription_id" id="prescription_id" class="form-control">
        <option selected disabled>Seleccionar receta médica</option>
          @foreach ($prescriptions as $prescription)
            <option value="{{ $prescription->id }}"
              @if (isset($order))
                @if ($order->prescription_id == $prescription->id)
                  selected
                @endif
              @endif
            >{{ $prescription->code }}</option>
          @endforeach
      </select>
      @if ($errors->has('prescription_id'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('prescription_id') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('service_id') ? ' has-error' : '' }}">
    <label for="service_id" class="col-md-3 control-label">Servicio</label>
    <div class="col-md-9">
      <select name="service_id" id="service_id" class="form-control">
        <option selected disabled>Seleccionar servicio</option>
        @foreach ($services as $service)
          <option value="{{ $service->id }}"
            @if (isset($order))
              @if ($order->service_id == $service->id)
                selected
              @endif
            @endif
          >{{ $service->name }}</option>
        @endforeach
      </select>
      @if ($errors->has('service_id'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('service_id') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
    <label for="product_id" class="col-md-3 control-label">Productos</label>
    <div class="col-md-9">
      <select name="product_id" id="product_id" class="form-control">
        <option selected disabled>Seleccionar productos</option>
        @foreach ($products as $product)
          <option value="{{ $product->id }}"
            @if (isset($order))
              @if ($order->product_id == $product->id)
                selected
              @endif
            @endif
          >{{ $product->name }}</option>
        @endforeach
      </select>
      @if ($errors->has('product_id'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('product_id') }}</strong>
        </p>
      @endif
    </div>
  </div>

  @if (Auth::user()->is_administrator())
    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
      <label for="status" class="col-md-3 control-label">Estado</label>
      <div class="col-md-9">
        <select name="status" id="status" class="form-control">
          <option selected disabled>Seleccionar Estado</option>
          <option value="Disponible">Disponible</option>
          <option value="Reservado">Reservado</option>
          <option value="En proceso">En proceso</option>
        </select>
      </div>
    </div>
  @else
    <input type="hidden" name="status" value="Reservado">
  @endif

  <div class="form-group">
    <label for="" class="col-md-3 control-label"></label>
    <div class="col-md-9">
      <input class="btn btn-primary" type="submit" value="Guardar">
      <a class="uk-button uk-button-default" href="{{ route('orders.index') }}">REGRESAR</a>
    </div>
  </div>

</form>
