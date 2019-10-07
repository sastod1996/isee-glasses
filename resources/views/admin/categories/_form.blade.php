<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($category) ? route('categories.update', ['id' => $category->id]) : route('categories.store') }}">
  {{ csrf_field() }}

  @if (isset($category))
    <input type="hidden" name="_method" value="put">
  @endif

  <div class="uk-width-1-1 uk-margin {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="name">Nombre</label>
    <div class="uk-form-controls">
      <input class="uk-input" id="name" name="name" type="text" value="{{ old('name', isset($category) ? $category->name : '') }}">
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
      <input class="uk-input" id="name_en" name="name_en" type="text" value="{{ old('name_en', isset($category) ? $category->name_en : '') }}">
      @if ($errors->has('name_en'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('name_en') }}</strong>
        </div>
      @endif
    </div>
  </div>

  @if (isset($category))
    <input type="hidden" name="slug" value="{{ $category->slug }}">
  @else
    <div class="uk-width-1-1 uk-margin {{ $errors->has('slug') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="slug">Slug</label>
      <div class="uk-form-controls">
        <input class="uk-input" id="slug" name="slug" type="text" value="{{ old('slug', isset($category) ? $category->slug : '') }}">
        @if ($errors->has('slug'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('slug') }}</strong>
          </div>
        @endif
      </div>
    </div>
  @endif

  <div class="uk-width-1-1 uk-margin {{ $errors->has('description') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="description">Descripción</label>
    <div class="uk-form-controls">
      <textarea class="uk-textarea" name="description" rows="3">{{ old('description', isset($category) ? $category->description : '') }}</textarea>
      @if ($errors->has('description'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('description') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
    </div>
  </div>
</form>
