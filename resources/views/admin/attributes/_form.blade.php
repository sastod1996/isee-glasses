<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($attribute) ? route('attributes.update', ['id' => $attribute->id]) : route('attributes.store') }}" uk-grid>
  {{ csrf_field() }}

  @if (isset($attribute))
    <input type="hidden" name="_method" value="put">
  @endif

  <div class="uk-width-1-2@s uk-width-1-1 uk-margin">
    <label class="uk-form-label" for="promo">Características</label>
    <div class="uk-form-controls">
      @if (isset($characteristic))
        {{-- @if ($characteristic->slug == 'color') --}}
          <input type="hidden" name="characteristic_id" value="{{ $characteristic->id }}">
          <input class="uk-input" type="text" value="{{ $characteristic->name }}" disabled>
        {{-- @endif --}}
      @else
        <select class="uk-select" name="characteristic_id">
          @foreach ($characteristics as $characteristic)
            <option value="{{ $characteristic->id }}"
              @if (isset($attribute))
                @if ($attribute->characteristic->id == $characteristic->id)
                  selected
                @endif
              @endif
              >{{ $characteristic->name }}
            </option>
          @endforeach
        </select>
      @endif
      @if ($errors->has('characteristic_id'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('characteristic_id') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@s uk-width-1-1 uk-margin {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="name">Nombre</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="name" name="name" type="text" value="{{ old('name', isset($attribute) ? $attribute->name : '') }}" maxlength="45">
      @if ($errors->has('name'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('name') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@s uk-width-1-1 uk-margin {{ $errors->has('name_en') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="name_en">Nombre (Inglés)</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="name_en" name="name_en" type="text" value="{{ old('name_en', isset($attribute) ? $attribute->name_en : '') }}" maxlength="45">
      @if ($errors->has('name_en'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('name_en') }}</strong>
        </div>
      @endif
    </div>
  </div>

  {{-- @if (isset($attribute))
    <div class="uk-width-1-2@s uk-width-1-1 uk-margin {{ $errors->has('status') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="status">Estado</label>
      <div class="uk-form-controls">
        <div class="">
          <label>
            <input class="uk-radio" type="radio" name="status" value="1"
            @isset($attribute)
              @if ($attribute->status == 1)
                 checked
              @endif
            @endisset
            > Activo
          </label><br>
          <label>
            <input class="uk-radio" type="radio" name="status" value="0"
            @isset($attribute)
              @if ($attribute->status == 0)
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
  @else --}}
    <input type="hidden" name="status" value="1">
  {{-- @endif --}}
  {{-- <input type="hidden" name="view" value="1">
  <input type="hidden" name="premium" value="0"> --}}

  @if (isset($characteristic))
    @if ($characteristic->slug == 'color')
      <input type="hidden" name="view" value="1">
      <input type="hidden" name="premium" value="0">

      <div class="uk-width-1-2@s uk-width-1-1 uk-margin {{ $errors->has('primary') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="primary">Color primario</label>
        <div class="uk-form-controls">
          <select class="uk-select" id="primary" name="primary">
            <option value="" selected disabled>Seleccionar color</option>
            @foreach ($primaries as $primary)
              <option value="{{ $primary->value }}"
              @if (isset($attribute))
                @if ($attribute->primary == $primary->value)
                  selected
                @endif
              @endif
              >{{ $primary->name }}</option>
            @endforeach
          </select>
          @if ($errors->has('primary'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('primary') }}</strong>
            </div>
          @endif
        </div>
      </div>
    @elseif ($characteristic->slug == 'marca')
      <div class="uk-width-1-2@s uk-width-1-1 uk-margin {{ $errors->has('premium') ? 'has-error' : '' }}">
        <input id="view" type="hidden" name="view" value="{{isset($attribute) ? $attribute->view : 1}}">
        <label class="uk-form-label" for="premium">Premium</label>
        <div class="uk-form-controls">
          <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
            @for ($i=0; $i < 2; $i++)
              <label>
                <input id="premium{{$i}}" type="radio" name="premium" value="{{$i}}"
                  @if (isset($attribute))
                    @if ($attribute->premium == $i)
                      checked
                    @endif
                  @endif
                > {{$i == 0 ? 'No' : 'Si'}}
              </label>
            @endfor
          </div>
          @if ($errors->has('primary'))
            <div class="uk-text-danger">
              <strong>{{ $errors->first('primary') }}</strong>
            </div>
          @endif
        </div>
      </div>
    @else
      <input type="hidden" name="view" value="1">
      <input type="hidden" name="premium" value="0">
    @endif
  @endif

  <div class="uk-width-1-1 uk-margin">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
      <a class="uk-button uk-button-default" href="{{ route('attributes.index') }}">REGRESAR</a>
    </div>
  </div>
</form>
