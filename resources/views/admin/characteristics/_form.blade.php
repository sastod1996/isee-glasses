<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($characteristic) ? route('characteristics.update', ['id' => $characteristic->id]) : route('characteristics.store') }}">
  {{ csrf_field() }}

  @if (isset($characteristic))
    <input type="hidden" name="_method" value="put">
  @endif

  <div class="uk-width-1-1 uk-margin {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="name">Nombre</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="name" name="name" type="text" value="{{ old('name', isset($characteristic) ? $characteristic->name : '') }}">
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
      <input class="uk-input" id="name_en" name="name_en" type="text" value="{{ old('name_en', isset($characteristic) ? $characteristic->name_en : '') }}">
      @if ($errors->has('name_en'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('name_en') }}</strong>
        </div>
      @endif
    </div>
  </div>

  @if (isset($characteristic))
    <input type="hidden" name="slug" value="{{ $characteristic->slug }}">
  @else
    <div class="uk-width-1-1 uk-margin {{ $errors->has('slug') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="slug">Slug</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="slug" name="slug" type="text" value="{{ old('slug', isset($characteristic) ? $characteristic->slug : '') }}">
        @if ($errors->has('slug'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('slug') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if (isset($characteristic))
    <div class="uk-width-1-1 uk-margin {{ $errors->has('status') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="status">Estado</label>
      <div class="uk-form-controls">
        <div class="">
          <label>
            <input class="uk-radio" type="radio" name="status" value="1"
              @isset($characteristic)
                @if ($characteristic->status == 1)
                  checked
                @endif
              @endisset
            > Activo
          <label> <br>
          <label>
            <input class="uk-radio" type="radio" name="status" value="0"
            @isset($characteristic)
              @if ($characteristic->status == 0)
                checked
              @endif
            @endisset
            > Inactivo
          </label>
        </div>
        @if ($errors->has('status'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('status') }}</strong>
          </div>
        @endif
      </div>
    </div>
    <input type="hidden" name="multiple" value="{{ $characteristic->multiple }}">
    <input type="hidden" name="deep" value="{{ $characteristic->deep }}">
  @else
    <input type="hidden" name="status" value="1">
    <input type="hidden" name="multiple" value="0">
    <input type="hidden" name="deep" value="1">
  @endif

  <div class="uk-width-1-1 uk-margin">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
    </div>
  </div>
</form>
