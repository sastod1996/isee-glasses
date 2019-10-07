<form class="form-horizontal" method="POST" action="{{ isset($prescription) ? route('prescriptions.update', ['id' => $prescription->id]) : route('prescriptions.store') }}" enctype="multipart/form-data">

  {{ csrf_field() }}

  @if (isset($prescription))
    <input type="hidden" name="_method" value="put">
  @endif

  <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
    <label for="code" class="col-md-3 control-label">Código</label>
    <div class="col-md-9">
      <input name="code" type="text" class="form-control" id="code" value="{{ old('code', isset($prescription) ? $prescription->code : '') }}">
      @if ($errors->has('code'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('code') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-3 control-label">Nombre</label>
    <div class="col-md-9">
      <input name="name" type="text" class="form-control" id="name" value="{{ old('name', isset($prescription) ? $prescription->name : '') }}">
      @if ($errors->has('name'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('name') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('measure_left') ? ' has-error' : '' }}">
    <label for="measure_left" class="col-md-3 control-label">Medida izquierda</label>
    <div class="col-md-9">
      <input name="measure_left" type="number" class="form-control" id="measure_left" value="{{ old('measure_left', isset($prescription) ? $prescription->measure_left : '') }}">
      @if ($errors->has('measure_left'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('measure_left') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('measure_right') ? ' has-error' : '' }}">
    <label for="measure_right" class="col-md-3 control-label">Medida derecha</label>
    <div class="col-md-9">
      <input name="measure_right" type="number" class="form-control" id="measure_right" value="{{ old('measure_right', isset($prescription) ? $prescription->measure_right : '') }}">
      @if ($errors->has('measure_right'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('measure_right') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
    <label for="file" class="col-md-3 control-label">Adjuntar receta</label>
    <div class="col-md-9">
      <input name="file" type="file" class="form-control" id="file" value="{{ old('file', isset($prescription) ? $prescription->file : '') }}">
      @if ($errors->has('file'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('file') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
    <label for="status" class="col-md-3 control-label">Estado</label>
    <div class="col-md-9">
      <div class="radio">
        <label><input type="radio" name="status" value="true">Activo</label>
        <label><input type="radio" name="status" value="false">Inactivo</label>
      </div>
      @if ($errors->has('status'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('status') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('client_id') ? ' has-error' : '' }}">
    <label for="client_id" class="col-md-3 control-label">Cliente</label>
    <div class="col-md-9">
      <select name="client_id" id="client_id" class="form-control">
        <option selected disabled>Seleccionar cliente</option>
          @foreach ($clients as $client)
            <option value="{{ $client->user_id }}"
              @if (isset($prescription))
                @if ($prescription->client_id == $client->user_id)
                  selected
                @endif
              @endif
            >{{ $client->user->first_name.' '.$client->user->last_name }}</option>
          @endforeach
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="" class="col-md-3 control-label"></label>
    <div class="col-md-9">
      <input class="btn btn-primary" type="submit" value="Guardar">
      <a class="uk-button uk-button-default" href="{{ route('prescriptions.index') }}">REGRESAR</a>
    </div>
  </div>

</form>
