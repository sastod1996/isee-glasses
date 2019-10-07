<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($slider) ? route('sliders.update', ['id' => $slider->id]) : route('sliders.store') }}" enctype="multipart/form-data">
  {{ csrf_field() }}

  @if (isset($slider))
    <input type="hidden" name="_method" value="put">
  @endif

  <div class="uk-width-2-3 uk-margin-auto">
    <div class="uk-margin {{ $errors->has('image') ? 'has-error' : '' }}">
      <label class="uk-form-label" for="image">Imagen</label>
      <div class="uk-form-controls">
        @if (isset($slider))
          <div class="isee-slider-append">
            <div class="isee-slider-div">
              <input class="uk-input" id="image" name="image" type="hidden" value="{{ $slider->image }}">
              <div class="">
                <img class="" src="{{ $slider->image }}" alt="">
              </div>
              <div class="">
                <a class="uk-button uk-button-default uk-width-1-1 isee-slider-change" href="#">Cambiar de imagen</a>
              </div>
            </div>
          </div>
        @else
          <div class="uk-width-1-1 uk-inline" uk-form-custom>
            <input class="slider-image" type="file" name="image">
            <a class="uk-form-icon uk-form-icon-flip isee-upload-image" href="#" uk-icon="icon: link" type="button" tabindex="-1"></a>
            <input class="uk-input slider-filename" type="text">
          </div>
          <div class="">
            Se recomienda una imagen de 1360x700
          </div>
        @endif
        @if ($errors->has('image'))
          <div class="uk-text-danger">
            <strong>{{ $errors->first('image') }}</strong>
          </div>
        @endif
      </div>
    </div>

    @if (isset($slider))
      <div class="uk-margin {{ $errors->has('status') ? 'has-error' : '' }}">
        <label class="uk-form-label" for="status">Estado</label>
        <div class="uk-form-controls">
          <div class="">
            <label>
              <input class="uk-radio" type="radio" name="status" value="1"
              @isset($slider)
                @if ($slider->status == 1)
                   checked
                @endif
              @endisset
              > Activo
            </label><br>
            <label>
              <input class="uk-radio" type="radio" name="status" value="0"
              @isset($slider)
                @if ($slider->status == 0)
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
        <a class="uk-button uk-button-default" href="{{ route('sliders.index') }}">REGRESAR</a>
      </div>
    </div>
  </div>
</form>

@push('js')
  <script>
    $('.isee-slider-change').click(function(){
      $('.isee-slider-append').append("\
      <div uk-form-custom>\
        <input type='file' name='image'>\
        <button class='uk-button uk-button-default' type='button' tabindex='-1'>Seleccionar imagen</button>\
      </div>\
      ");
      $('.isee-slider-div').remove()
    });

    $('.attribute').on('click', function(){
      var attribute_id = $(this).val()
      var characteristic = $(this).attr('characteristic');
      if ($(this).is(':checked')) {
        if (characteristic == 'color') {
          var files = $('#input-files'+attribute_id)
          files.show()
        }else if (characteristic == 'tamanio') {
          var sizes = $('#input-sizes'+attribute_id)
          sizes.show()
        }
      }else {
        if (characteristic == 'color') {
          var files = $('#input-files'+attribute_id)
          files.hide()
        } else if (characteristic == 'tamanio') {
          var sizes = $('#input-sizes'+attribute_id)
          sizes.hide()
        }
      }
    });
  </script>

  <script>
    $('.slider-image').change(function(){
      var filename = $(this).val()
      filename = filename.split(/(\\|\/)/g).pop()
      $('.slider-filename').val(filename)
    });
  </script>
@endpush
