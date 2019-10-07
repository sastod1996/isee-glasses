<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($type) ? route('characteristics.update', ['id' => $type->id]) : route('characteristics.store') }}">
  {{ csrf_field() }}

  @if (isset($type))
    <input type="hidden" name="_method" value="put">
  @endif

  <div class="uk-width-1-1 uk-margin {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="name">Nombre</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="name" name="name" type="text" value="{{ old('name', isset($type) ? $type->name : '') }}">
      @if ($errors->has('name'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('name') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin {{ $errors->has('name_en') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="name_en">Nombre (Inglés)</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="name_en" name="name_en" type="text" value="{{ old('name_en', isset($type) ? $type->name_en : '') }}">
      @if ($errors->has('name_en'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('name_en') }}</strong>
        </div>
      @endif
    </div>
  </div>

  @if (isset($type))
    <input type="hidden" name="slug" value="{{ $type->slug }}">
  @else
    <div class="uk-width-1-1 uk-margin {{ $errors->has('slug') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="slug">Slug</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="slug" name="slug" type="text" value="{{ old('slug', isset($type) ? $type->slug : '') }}">
        @if ($errors->has('slug'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('slug') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  <div class="uk-width-1-1 uk-margin">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
      <a class="uk-button uk-button-default" href="{{ route('types.index') }}">REGRESAR</a>
    </div>
  </div>
</form>
