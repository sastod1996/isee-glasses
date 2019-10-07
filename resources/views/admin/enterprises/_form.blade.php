<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($enterprise) ? route('enterprises.update', ['id' => $enterprise->id]) : route('enterprises.store') }}" enctype="multipart/form-data">
  {{ csrf_field() }}

  @if (isset($enterprise))
    <input type="hidden" name="_method" value="put">
  @endif


  <div class="uk-width-2-3 uk-margin-auto">
    <div class="uk-margin {{ $errors->has('name') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="name">Nombre</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="name" name="name" type="text" value="{{ isset($enterprise) ? $enterprise->name : '' }}">
        @if ($errors->has('name'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('name') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="uk-width-1-1 uk-margin">
      <div class="uk-form-controls">
        <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
        <a class="uk-button uk-button-default" href="{{ route('enterprises.index') }}">REGRESAR</a>
      </div>
    </div>
  </div>
</form>
