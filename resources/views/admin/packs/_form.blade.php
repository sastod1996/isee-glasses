<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($pack) ? route('packs.update', ['id' => $pack->id]) : route('packs.store') }}">
  {{ csrf_field() }}

  @if (isset($pack))
    <input type="hidden" name="_method" value="put">
  @endif

  <div class="uk-width-1-1 uk-margin {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="name">Nombre</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="name" name="name" type="text" value="{{ old('name', isset($pack) ? $pack->name : '') }}">
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
      <input class="uk-input" id="name_en" name="name_en" type="text" value="{{ old('name_en', isset($pack) ? $pack->name_en : '') }}">
      @if ($errors->has('name_en'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('name_en') }}</strong>
        </div>
      @endif
    </div>
  </div>

  @if (isset($pack))
    <input type="hidden" name="slug" value="{{ $pack->slug }}">
  @else
    <div class="uk-width-1-1 uk-margin {{ $errors->has('slug') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="slug">Slug</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="slug" name="slug" type="text" value="{{ old('slug', isset($pack) ? $pack->slug : '') }}">
        @if ($errors->has('slug'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('slug') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if (isset($pack))
    <div class="uk-width-1-1 uk-margin {{ $errors->has('status') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="status">Estado</label>
      <div class="uk-form-controls">
        <div class="">
          <label>
            <input class="uk-radio" type="radio" name="status" value="1"
            @isset($pack)
              @if ($pack->status == 1)
                 checked
              @endif
            @endisset
            > Activo
          </label><br>
          <label>
            <input class="uk-radio" type="radio" name="status" value="0"
            @isset($pack)
              @if ($pack->status == 0)
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
  @else
    <input type="hidden" name="status" value="1">
  @endif

  <div class="uk-width-1-1 uk-margin">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
      <a class="uk-button uk-button-default" href="{{ route('packs.index') }}">REGRESAR</a>
    </div>
  </div>
</form>
