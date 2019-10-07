<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($popup) ? route('popups.update', ['id' => $popup->id]) : route('popups.store') }}" enctype="multipart/form-data" uk-grid>
{{-- {{dd($errors)}} --}}
  {{ csrf_field() }}

  @if (isset($popup))
    <input type="hidden" name="_method" value="put">
  @endif

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="name" class="uk-form-label">Nombre</label>
    <div class="uk-form-controls">
      <input name="name" type="text" id="name" value="{{ old('name', isset($popup) ? $popup->name : '') }}" class="uk-input{{ $errors->has('name') ? ' uk-form-danger' : '' }}" maxlength="45" >
      @if ($errors->has('name'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('name') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="title" class="uk-form-label">Título</label>
    <div class="uk-form-controls">
      <input name="title" type="text" id="title" value="{{ old('title', isset($popup) ? $popup->title : '') }}" class="uk-input{{ $errors->has('title') ? ' uk-form-danger' : '' }}" maxlength="45" >
      @if ($errors->has('title'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('title') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="coupon_id" class="uk-form-label">Cupón</label>
    <div class="uk-form-controls">
      <select name="coupon_id" id="coupon_id" class="uk-select{{ $errors->has('coupon_id') ? ' uk-form-danger' : '' }}">
        @foreach ($coupons as $coupon)
          <option value="{{$coupon->id}}"
            @if (isset($popup))
              @if ($coupon->id == $popup->coupon_id)
                selected
              @endif
            @endif
          >{{ $coupon->code }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="text_close" class="uk-form-label">Texto cerrar</label>
    <div class="uk-form-controls">
      <input name="text_close" type="text" id="text_close" value="{{ old('text_close', isset($popup) ? $popup->text_close : '') }}" class="uk-input{{ $errors->has('text_close') ? ' uk-form-danger' : '' }}" maxlength="45" >
      @if ($errors->has('text_close'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('text_close') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="text_main" class="uk-form-label">Texto Principal</label>
    <div class="uk-form-controls">
      <textarea class="uk-textarea" name="text_main" rows="4">{{ isset($popup) ? $popup->text_main : '' }}</textarea>
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="text_secondary" class="uk-form-label">Texto Secundario</label>
    <div class="uk-form-controls">
      <textarea class="uk-textarea" name="text_secondary" rows="4">{{ isset($popup) ? $popup->text_secondary : '' }}</textarea>
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="status" class="uk-form-label">Estado</label>
    <div class="uk-form-controls">
      <select name="status" id="status" class="uk-select{{ $errors->has('status') ? ' uk-form-danger' : '' }}">
        <option value="1"
          @if (isset($popup))
            @if ($popup->status)
              selected
            @endif
          @endif
        >Activo</option>
        <option value="0"
          @if (isset($popup))
            @if (!$popup->status)
              selected
            @endif
          @endif
        >Inactivo</option>
      </select>
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="end_date" class="uk-form-label">Fecha Fin</label>
    <div class="uk-form-controls">
      <input name="end_date" type="date" id="end_date" value="{{ old('end_date', isset($popup) ? $popup->end_date : '') }}" class="uk-input{{ $errors->has('end_date') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('end_date'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('end_date') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-margin {{ $errors->has('image') ? 'has-error' : '' }}">
    <label class="uk-form-label" for="image">Imagen</label>
    <div class="uk-form-controls">
      @if (isset($popup))
        <div class="isee-popup-append">
          <div class="isee-popup-div">
            <input class="uk-input" id="image" name="image" type="hidden" value="{{ $popup->image }}">
            <div class="">
              <img class="uk-text-center uk-width-1-1" src="{{ $popup->image }}" alt="">
            </div>
            <div class="">
              <a class="uk-button uk-button-default uk-width-1-1 isee-popup-change" href="#">Cambiar de imagen</a>
            </div>
          </div>
        </div>
        <div class="">
          Se recomienda una imagen de 900x560
        </div>
      @else
        <div class="uk-width-1-1 uk-inline" uk-form-custom>
          <input class="popup-image" type="file" name="image">
          <a class="uk-form-icon uk-form-icon-flip isee-upload-image" href="#" uk-icon="icon: link" type="button" tabindex="-1"></a>
          <input class="uk-input popup-filename" type="text">
        </div>
        <div class="">
          Se recomienda una imagen de 900x560
        </div>
      @endif
      @if ($errors->has('image'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('image') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin">
    <label for="message_presentation" class="uk-form-label">Mensaje de presentación</label>
    <div class="uk-form-controls">
      <textarea class="uk-textarea" name="message_presentation" rows="3">{{ isset($popup) ? $popup->message_presentation : '' }}</textarea>
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin">
    <label for="message_coupon" class="uk-form-label">Mensaje de cupón</label>
    <div class="uk-form-controls">
      <textarea class="uk-textarea" name="message_coupon" rows="3">{{ isset($popup) ? $popup->message_coupon : '' }}</textarea>
    </div>
  </div>

  <div class="uk-width-1-1 uk-margin">
    <div class="uk-text-center">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
      <a class="uk-button uk-button-default" href="{{ route('popups.index') }}">REGRESAR</a>
    </div>
  </div>

</form>

@push('js')
  <script>
    $('.isee-popup-change').click(function(){
      $('.isee-popup-append').append("\
      <div uk-form-custom='target: true'>\
        <input type='file' name='image' accept='image/*'> \
        <input class='uk-input uk-form-width-large' type='text' placeholder='Seleccionar imagen' disabled>\
      </div>\
      ");
      $('.isee-popup-div').remove()
    });
  </script>

  <script>
    $('.popup-image').change(function(){
      var filename = $(this).val()
      filename = filename.split(/(\\|\/)/g).pop()
      $('.popup-filename').val(filename)
    });
  </script>
@endpush
