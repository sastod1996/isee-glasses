<form class="form-horizontal" method="POST" action="{{ isset($prescription) ? route('prescriptions.update', ['id' => $prescription->id]) : route('prescriptions.store') }}" enctype="multipart/form-data">

  {{ csrf_field() }}

  @if (isset($prescription))
    <input type="hidden" name="_method" value="put">
    <input type="hidden" name="code" value="{{ $prescription->code }}">
  @else
    <input type="hidden" name="code" value="{{ getCode('App\Prescription') }}">
  @endif

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
      <input name="file" type="file" id="file" value="{{ old('file', isset($prescription) ? $prescription->file : '') }}">
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

  <input type="hidden" name="client_id" value="{{ Auth::id() }}">

  <div class="form-group">
    <label for="" class="col-md-3 control-label"></label>
    <div class="col-md-9">
      <input class="btn btn-primary" type="submit" value="Guardar">
      <a class="uk-button uk-button-default" href="{{ route('prescriptions.index') }}">REGRESAR</a>
    </div>
  </div>

</form>
