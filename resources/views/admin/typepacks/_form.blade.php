<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($typepack) ? route('typepacks.update', ['id' => $typepack->id]) : route('typepacks.store') }}" uk-grid>
  {{ csrf_field() }}

  @if (isset($typepack))
    <input type="hidden" name="_method" value="put">
  @endif

  @if (isset($typepack))
    <input class="uk-input" id="type_id" type="hidden" name="type_id" value="{{ $typepack->type_id }}">
  @else
    <div class="uk-width-1-3 uk-margin {{ $errors->has('type_id') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="type_id">Tipo</label>
      <div class="uk-form-controls">
        <select class="uk-select" name="type_id">
          @foreach ($types as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
          @endforeach
        </select>
        @if ($errors->has('type_id'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('type_id') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if (isset($typepack))
    <input class="uk-input" id="pack_id" type="hidden" name="pack_id" value="{{ $typepack->pack_id }}">
  @else
    <div class="uk-width-1-3 uk-margin {{ $errors->has('pack_id') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="pack_id">Tipo</label>
      <div class="uk-form-controls">
        <select class="uk-select" name="pack_id">
          @foreach ($packs as $pack)
            <option value="{{ $pack->id }}">{{ $pack->name }}</option>
          @endforeach
        </select>
        @if ($errors->has('pack_id'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('pack_id') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  <div class="uk-width-1-1 uk-margin {{ $errors->has('price') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="price">Precio</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="price" name="price" type="number" value="{{ old('price', isset($typepack) ? $typepack->price : '') }}">
      @if ($errors->has('price'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('price') }}</strong>
        </div>
      @endif
    </div>
  </div>

  @if (isset($typepack))
    <input class="uk-input" id="esfmin" type="hidden" name="esfmin" value="{{ $typepack->esfmin }}">
  @else
    <div class="uk-width-1-2 uk-margin {{ $errors->has('esfmin') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="esfmin">Esfera (mínima)</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="esfmin" name="esfmin" type="number" value="{{ old('esfmin', isset($typepack) ? $typepack->esfmin : '') }}">
        @if ($errors->has('esfmin'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('esfmin') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if (isset($typepack))
    <input class="uk-input" id="esfmax" type="hidden" name="esfmax" value="{{ $typepack->esfmax }}">
  @else
    <div class="uk-width-1-2 uk-margin {{ $errors->has('esfmax') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="esfmax">Esfera (máxima)</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="esfmax" name="esfmax" type="number" value="{{ old('esfmax', isset($typepack) ? $typepack->esfmax : '') }}">
        @if ($errors->has('esfmax'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('esfmax') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if (isset($typepack))
    <input class="uk-input" id="cilmin" type="hidden" name="cilmin" value="{{ $typepack->cilmin }}">
  @else
    <div class="uk-width-1-2 uk-margin {{ $errors->has('cilmin') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="cilmin">Cilindro (mínima)</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="cilmin" name="cilmin" type="number" value="{{ old('cilmin', isset($typepack) ? $typepack->cilmin : '') }}">
        @if ($errors->has('cilmin'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('cilmin') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if (isset($typepack))
    <input class="uk-input" id="cilmax" type="hidden" name="cilmax" value="{{ $typepack->cilmax }}">
  @else
    <div class="uk-width-1-2 uk-margin {{ $errors->has('cilmax') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="cilmax">Cilindro (máxima)</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="cilmax" name="cilmax" type="number" value="{{ old('cilmax', isset($typepack) ? $typepack->cilmax : '') }}">
        @if ($errors->has('cilmax'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('cilmax') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if (isset($typepack))
    <input class="uk-input" id="material" type="hidden" name="material" value="{{ $typepack->material }}">
  @else
    <div class="uk-width-1-2 uk-margin {{ $errors->has('material') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="material">Material</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="material" name="material" type="text" value="{{ old('material', isset($typepack) ? $typepack->material : '') }}">
        @if ($errors->has('material'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('material') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if (isset($typepack))
    <input class="uk-input" id="material_en" type="hidden" name="material_en" value="{{ $typepack->material_en }}">
  @else
    <div class="uk-width-1-2 uk-margin {{ $errors->has('material_en') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="material_en">Material (inglés)</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="material_en" name="material_en" type="text" value="{{ old('material_en', isset($typepack) ? $typepack->material_en : '') }}">
        @if ($errors->has('material_en'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('material_en') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  <div class="uk-width-1-1 uk-margin {{ $errors->has('description') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="description">Descripción</label>
    <div class="uk-form-controls">
      <input class="uk-input textarea-form" id="description" name="description" type="text" value="{{ old('description', isset($typepack) ? $typepack->description : '') }}">
      @if ($errors->has('description'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('description') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin {{ $errors->has('description_en') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="description_en">Descripción (inglés)</label>
    <div class="uk-form-controls">
      <input class="uk-input textarea-form" id="description_en" name="description_en" type="text" value="{{ old('description_en', isset($typepack) ? $typepack->description_en : '') }}">
      @if ($errors->has('description_en'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('description_en') }}</strong>
        </div>
      @endif
    </div>
  </div>

  @if (isset($typepack))
    <input class="uk-input" id="help" type="hidden" name="help" value="{{ $typepack->help }}">
  @else
    <div class="uk-width-1-1 uk-margin {{ $errors->has('help') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="help">Ayuda</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="help" name="help" type="text" value="{{ old('help', isset($typepack) ? $typepack->help : '') }}">
        @if ($errors->has('help'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('help') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  @if (isset($typepack))
    <input class="uk-input" id="help_en" type="hidden" name="help_en" value="{{ $typepack->help_en }}">
  @else
    <div class="uk-width-1-1 uk-margin {{ $errors->has('help_en') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="help_en">Ayuda (inglés)</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="help_en" name="help_en" type="text" value="{{ old('help_en', isset($typepack) ? $typepack->help_en : '') }}">
        @if ($errors->has('help_en'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('help_en') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  <div class="uk-width-1-1 uk-margin">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
      <a class="uk-button uk-button-default" href="{{ route('typepacks.index') }}">REGRESAR</a>
    </div>
  </div>
</form>
