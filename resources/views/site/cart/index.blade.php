@push('head')
  <!-- Incluyendo .js de Culqi-->
  <script>
    window.culqi_pk = '{{ env('CULQI_PK') }}'
  </script>
  <script src="https://checkout.culqi.com/plugins/v2"></script>
@endpush

@push('js')
  <script src="{{ mix('js/site/cart.js') }}"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="/css/site/pages/cart.css">
@endpush

@extends('layouts.site')

@section('content')

  @php
    $symbol = Auth::user()->rate->symbol;
    $value = Auth::user()->rate->value;
    $cartContent = Cart::content();

    //Archivo de lenguaje
    $titles = __('cart');
    $forms = __('forms');
    $terms = __('terms');
    $titles = json_decode(json_encode($titles));
    $forms = json_decode(json_encode($forms));
    $terms = json_decode(json_encode($terms));
    $titles = collect(['principal' => $titles, 'forms' => $forms, 'terms' => $terms]);

    $lang = App::getLocale();
  @endphp

   <div id="cart">
     <cart :lang="'{{ $lang }}'" :titles="{{ $titles->toJson() }}" :symbol="'{{ $symbol }}'" :value="{{ $value }}" :preorder="{{ $preorder->toJson() }}" :user="{{ $user->toJson()}}" :districts="{{ $districts->toJson() }}"></cart>
   </div>

@endsection

@push('js')
  <script>
    $(document).ready(function() {
      $('#select-district').val($('#input-district').val());
      showDistricts();
    });

    $('#city').change(function(){
      showDistricts()
    });

    $('#country').change(function(){
      showInput()
    });

    function showDistricts() {
      if ($('#city').val() != 'Lima') {
        showInput()
      }else {
        showSelect()
      }
    }

    function showInput(){
      $('#select-district').addClass("uk-hidden")
      $('#select-district').removeAttr("name")
      $('#input-district').removeClass("uk-hidden")
      $('#input-district').attr("name", 'district')
    }

    function showSelect(){
      $('#select-district').removeClass("uk-hidden")
      $('#select-district').attr("name", 'district')
      $('select option[value="0"]').attr("selected",true);
      $('#input-district').addClass("uk-hidden")
      $('#input-district').removeAttr("name")
      $('#input-district').val("")
    }
  </script>
@endpush

@push('js')
  <script>
    var cart, amount

    function validateForm(){
      var status = true;
      if(!$('#first_name').val()){
        $('#first_name').addClass('uk-form-danger')
        $('#msgValidate').removeClass('uk-hidden')
        status = false
      }
      if(!$('#last_name').val()){
        $('#last_name').addClass('uk-form-danger')
        $('#msgValidate').removeClass('uk-hidden')
        status = false
      }
      if(!$('#telephone').val()){
        $('#telephone').addClass('uk-form-danger')
        $('#msgValidate').removeClass('uk-hidden')
        status = false
      }
      if(!$('[name = district]').val()){
        $('#district').addClass('uk-form-danger')
        $('#msgValidate').removeClass('uk-hidden')
        status = false
      }
      if(!$('#address').val()){
        $('#address').addClass('uk-form-danger')
        $('#msgValidate').removeClass('uk-hidden')
        status = false
      }
      return status
    }

    function setValues(cart, amount){
      this.cart = cart;
      this.amount = amount
    }
    function culqi() {
      if (Culqi.token) {
        var token = Culqi.token.id;
          $.ajax({
            type:'POST',
            url: '/checkout',
            data: JSON.stringify({
              "source_id": Culqi.token.id,
              "installments": Culqi.token.metadata.installments,
              "amount": amount,
              "currency_code": "{{isset( Auth::user()->client) ? isset(Auth::user()->rate) ? Auth::user()->rate->code : 'PEN' : 'PEN' }}",
              "email": "{{ Auth::user()->email }}",
              "first_name": $('#first_name').val(),
              "last_name": $('#last_name').val(),
              "telephone": $('#telephone').val(),
              "country": $('#country').val(),
              "city": $('#city').val(),
              "district": $('[name=district]').val(),
              "address": $('#address').val(),
              "postal_code": $('#postal_code').val(),
              "reference": $('#reference').val(),
              "user_id": "{{ Auth::user()->id }}",
              "rate_id": "{{isset( Auth::user()->client) ? Auth::user()->rate->id : 1}}",
              // "coupon_id": cart.coupon_id,
              // "discount": cart.discount,
              // "subtotal": cart.subtotal,
              // // "igv": 0,
              // "price": cart.total,
              // "products": !! $cartContent !!
              "preorder": cart
            }),
            contentType: "application/json",
            error: function(){
              $('#modal-close-default').addClass('uk-open').css('display','block')
              $("#iframeloading").hide();
            },
            beforeSend: function(){
              $("#iframeloading").show();
            }
          }).done(function(response){
            if (response.success) {
              UIkit.notification({
                message: 'Exitoso',
                status: 'success',
                pos: 'bottom-center',
                timeout: 5000
              });
              $("#iframeloading").hide();
              $('#second-content').removeClass('uk-active')
              $('#second').removeClass('uk-active')
              $('#second').attr('aria-expanded', 'false')

              $('#third').attr('aria-expanded', 'true')
              $('#third').addClass('uk-active')
              $('#third-content').addClass('uk-active')

              $('#background2').addClass("uk-hidden")
              $('#background3').removeClass("uk-hidden")
            } else {
              Ikit.notification({
                message: response.message,
                status: 'danger',
                pos: 'bottom-center',
                timeout: 5000
              });
            }
          });
      } else {
        // console.log('Error Culqi: ');
        // console.log(Culqi.error)
        $('#modal-close-default').addClass('uk-open').css('display','block')
      }
  };
  </script>
@endpush

@push('js')
  <script>
    $('#siguiente').on('click', function(){
      $('#background1').addClass("uk-hidden")
      $('#background2').removeClass("uk-hidden")
    })

    $('#regresar').on('click', function(){
      $('#background2').addClass("uk-hidden")
      $('#background1').removeClass("uk-hidden")
    })

    $('#regresar').on('click', function(){
      $('#background2').addClass("uk-hidden")
      $('#background1').removeClass("uk-hidden")
    })
  </script>
@endpush
