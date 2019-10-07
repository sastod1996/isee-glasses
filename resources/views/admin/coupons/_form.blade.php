<form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ isset($coupon) ? route('coupons.update', ['id' => $coupon->id]) : route('coupons.store') }}" uk-grid>
{{-- {{dd($errors)}} --}}
  {{ csrf_field() }}

  @if (isset($coupon))
    <input type="hidden" name="_method" value="put">
@endif
<input type="hidden" id="coupon" value="{{isset($coupon) ? true : false}}">

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="code" class="uk-form-label">Código</label>
    <div class="uk-form-controls">
      <input name="code" type="text" id="code" value="{{ old('code', isset($coupon) ? $coupon->code : '') }}" class="uk-input{{ $errors->has('code') ? ' uk-form-danger' : '' }}" maxlength="45" >
      @if ($errors->has('code'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('code') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="affiliate_id" class="uk-form-label">Afiliado</label>
    <div class="uk-form-controls">
      <select name="affiliate_id" id="affiliate_id" class="uk-select{{ $errors->has('affiliate_id') ? ' uk-form-danger' : '' }}">
        <option value="0">Sin Afiliado</option>
        @foreach ($affiliates as $affiliate)
          <option value="{{$affiliate->user_id}}"
            @if (isset($coupon))
              @if ($affiliate->user_id == $coupon->affiliate_id)
                selected
              @endif
            @endif
          >{{$affiliate->user->last_name}}, {{$affiliate->user->first_name}}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="comission uk-width-1-2@m uk-width-1-1 uk-margin"
    @if ( !isset($coupon) || $coupon->affiliate_id == 0)
      style="display:none"
    @endif
    >
    <label for="percent_commission" class="uk-form-label">Porcentaje de comisión (%)</label>
    <div class="uk-form-controls">
      <input name="percent_commission" type="number" id="percent_commission" value="{{ old('percent_commission', isset($coupon) ? $coupon->percent_commission : 0) }}" class="uk-input{{ $errors->has('percent_commission') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('percent_commission'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('percent_commission') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="comission uk-width-1-2@m uk-width-1-1 uk-margin"
    @if (!isset($coupon) || $coupon->affiliate_id == 0)
      style="display:none"
    @endif
    >
    <label for="max_commission" class="uk-form-label">Límite de comisión (S/.)</label>
    <div class="uk-form-controls">
      <input name="max_commission" type="number" id="max_commission" value="{{ old('max_commission', isset($coupon) ? $coupon->max_commission : 0) }}" class="uk-input{{ $errors->has('max_commission') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('max_commission'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('max_commission') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="percent" class="uk-form-label">Porcentaje del cupón (%)</label>
    <div class="uk-form-controls">
      <input name="percent" type="number" id="percent" value="{{ old('percent', isset($coupon) ? $coupon->percent : '') }}" class="uk-input{{ $errors->has('percent') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('percent'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('percent') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="limit" class="uk-form-label">Límite (S/.)</label>
    <div class="uk-form-controls">
      <input name="limit" type="number" id="limit" value="{{ old('limit', isset($coupon) ? $coupon->limit : '') }}" placeholder="Monto máximo a descontar" class="uk-input{{ $errors->has('limit') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('limit'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('limit') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="start_date" class="uk-form-label">Fecha Inicio</label>
    <div class="uk-form-controls">
      <input name="start_date" type="date" id="start_date" value="{{ old('start_date', isset($coupon) ? $coupon->start_date : '') }}" class="uk-input{{ $errors->has('start_date') ? ' uk-form-danger' : '' }}" >
      @if ($errors->has('start_date'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('start_date') }}</strong>
        </p>
      @endif
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="end_date" class="uk-form-label">Fecha Fin</label>
    <div class="uk-form-controls">
      <input name="end_date" type="date" id="end_date" value="{{ old('end_date', isset($coupon) ? $coupon->end_date : '') }}" class="uk-input{{ $errors->has('end_date') ? ' uk-form-danger' : '' }}">
      @if ($errors->has('end_date'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('end_date') }}</strong>
        </p>
      @endif
    </div>
  </div>

  {{-- Caracteristica - Atributo - 1 --}}
  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="attrs[]" class="uk-form-label">Característica</label>
    <div class="uk-form-controls">
      <select class="uk-select characteristics0 {{ $errors->has('attr') ? ' uk-form-danger' : '' }}">
        <option value="0">Sin caracteristica</option>
        @foreach ($characteristics as $characteristic)
          <option value="{{$characteristic->id}}"
            @if (isset($coupon))
              @if (isset($coupon->attributes[0]))
                @if ($coupon->attributes[0]->characteristic_id == $characteristic->id)
                  selected
                @endif
              @endif
            @endif
          >{{$characteristic->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="attr" class="uk-form-label">Atributo</label>
    <div class="uk-form-controls">
      <select id="attrs0" name="attr" class="uk-select attributes0 {{ $errors->has('attr') ? ' uk-form-danger' : '' }}">
        <option value="0">-</option>
        @foreach ($attributes as $attribute)
          <option value="{{$attribute->id}}" data-characteristic="{{$attribute->characteristic_id}}"
            @if (isset($coupon))
              @if ($coupon->attributes->count() > 0)
                @if ($coupon->attributes[0]->id == $attribute->id)
                  selected
                @endif
              @endif
            @endif
          >{{$attribute->name}}</option>
        @endforeach
      </select>
      @if ($errors->has('attr'))
        <p class="uk-text-danger">
          <strong>{{ $errors->first('attr') }}</strong>
        </p>
      @endif
    </div>
  </div>

  {{-- Tipo --}}
  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="type" class="uk-form-label">Tipo</label>
    <div class="uk-form-controls">
      <select name="type" class="uk-select">
        <option selected value="0">Sin tipo</option>
        @foreach ($types as $type)
          <option value="{{$type->id}}"
            @if (isset($coupon))
              @if ($coupon->types->count() > 0)
                @if (isset($coupon->types[0]))
                  @if ($coupon->types[0]->id == $type->id)
                    selected
                  @endif
                @endif
              @endif
            @endif
          >{{$type->name}}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="uk-width-1-2@m uk-width-1-1 uk-margin">
    <label for="status" class="uk-form-label">Estado</label>
    <div class="uk-form-controls">
      <select name="status" id="status" class="uk-select{{ $errors->has('status') ? ' uk-form-danger' : '' }}">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
      </select>
    </div>
  </div>

  <div class="comission uk-width-1-2@m uk-width-1-1 uk-margin"
    @if (!isset($coupon) || $coupon->affiliate_id == 0)
      style="display:none"
    @endif
  >
    <label for="payment_status" class="uk-form-label">Estado de pago</label>
    <div class="uk-form-controls">
      <select name="payment_status" id="payment_status" class="uk-select {{ $errors->has('payment_status') ? ' uk-form-danger' : '' }}">
        {{-- <option value="" disabled selected>Seleccionar estado</option> --}}
        <option value="0">Pendiente</option>
        <option value="1">Pagado</option>
      </select>
    </div>
  </div>

  <div class="uk-width-1-1@m uk-margin uk-flex-middle ">
    <div class="uk-form-controls">
      <input class="uk-button uk-background-primary uk-light" type="submit" value="GUARDAR">
      <a class="uk-button uk-button-default" href="{{ route('coupons.index') }}">REGRESAR</a>
    </div>
  </div>

</form>

@push('js')
  <script>
    var char
    var options = $('#attrs0 option')
    var coupon = $('#coupon').val()

    // Iniciando valores por default
    if (!coupon) {
      $('.characteristics0').val(1) //marca
      updateOptions(1,0)
      // $('.characteristics1').val(0)
      // updateOptions(0,1)
      // $('.attributes1').empty()
    }

    $('.characteristics0').change(function(){
      char = $('.characteristics0').val()
      updateOptions(char, 0)
    });

    // $('.characteristics1').change(function(){
    //   char = $('.characteristics1').val()
    //   updateOptions(char, 1)
    // });

    function updateOptions(chars, i){
      $('.attributes'+i+'').empty()

      options.each(function() {
        if ($(this).data('characteristic') == chars) {
          $('.attributes'+i+'').append(this);
        }
      });
    }
  </script>
@endpush

@push('js')
  <script>
    $('#affiliate_id').change(function(){
      if ($('#affiliate_id').val() != 0) {
        $('.comission').show()
      }else{
        $('.comission').hide()
        // $('#percent_commission').attr('value',null)
        $('#percent_commission').val("")
        $('#max_commission').val("")
        $('#payment_status').val("")
      }
    });

  </script>

@endpush
