{{--  My footer is here - #LuceritoSad--}}
<div class="uk-section uk-padding-remove-bottom uk-margin-bottom uk-background-muted">
  <div class="uk-container">
    <div class="uk-child-width-1-4@s uk-child-width-1-1@s uk-grid" uk-grid>
      <div class="">
        <div class="uk-visible@s">
          <img src="/pages/inicio/logo.png" alt="">
        </div>
      </div>
      <div class="">
        <p class="isee-h5 uk-margin-small isee-bold">@lang('footer.contactanos')</p>
        <p class="uk-margin-small">service@isee-glasses.com</p>
        <p class="isee-h5 uk-margin-small isee-bold">@lang('footer.wtsp') / FACEBOOK</p>
        <p class="uk-margin-small">
          <img src="/pages/partials/whatsapp.png" alt="">
          (+511) 946 037 096
        </p>
        <p class="uk-margin-small">
          <a class="uk-link-reset" href="https://www.facebook.com/Isee-glasses-1764544160226937/" target="_blank">
            <img src="/pages/partials/facebook.png" alt="">
            Isee Glasses
          </a>
        </p>
      </div>
      <div class="">
        <p class="isee-h5 isee-bold">@lang('footer.medio-pago')</p>
        <p class="uk-margin-small" >
          <img src="/pages/carrito/tarjetaspago5.jpg" style="height:30px;">
          <img src="/pages/carrito/tarjetaspago6.jpg" style="height:30px;">
          <img src="/pages/carrito/tarjetaspago7.jpg" style="height:30px;">
          <img src="/pages/carrito/tarjetaspago8.jpg" style="height:30px;">
        </p>
        <p class="isee-h5 uk-margin-small isee-bold">@lang('footer.rate')</p>
        <a class="isee-h5 uk-margin-small isee-bold uk-link-reset" href="{{ route('changeRate', ['slug' => 'dolares']) }}" data-method="post">USD</a>
        <a class="isee-h5 uk-margin-small isee-bold uk-link-reset" href="{{ route('changeRate', ['slug' => 'soles']) }}" data-method="post">PEN</a>
      </div>
      <div class="uk-flex-middle">
        <ul class="uk-list">
        <li>
          <img src="/pages/partials/icon1.png" title="Compras a un click" alt="">
          Compras a un click
        </li>
        <li>
          <img src="/pages/partials/icon2.png" title="Precios bajos, misma calidad" alt="">
          Precios bajos, misma calidad
        </li>
        <li>
          <img src="/pages/partials/icon3.png" title="Probador de gafas virtual" alt="">
          Probador de gafas virtual
        </li>
        <li>
          <img src="/pages/partials/icon4.png" title="Devolución total" alt="">
          Devolución total
        </li>
        <li>
          <img src="/pages/partials/icon5.png" title="Envíos gratuitos" alt="">
          Envíos gratuitos
        </li>
        <li></li>
      </ul>
      </div>
    </div>
    <div class="uk-margin-medium">
      <div class="uk-text-muted uk-text-center">
        Powered by <a class="uk-link-reset uk-text-bold" target="_blank" style="" href="https://prodequa.com">Prodequa</a>
      </div>
    </div>
  </div>
</div>

{{--  --}}
<div class="uk-hidden@s">
  <div id="isee-hidden" class="widget-small uk-container-small uk-text-center uk-flex uk-flex-center uk-flex-middle" style="z-index: 1000;">
    <div class="uk-flex uk-flex-middle uk-flex-center uk-width-1-1">
      <div class="uk-text-center">
        <a href="whatsapp://send?phone=51946037096">
          <img class="uk-width-1-1" src="/pages/whatsapp.png">
        </a>
      </div>
    </div>
  </div>
</div>

<div class="uk-visible@s">
  <div id="isee-visible" href="" class="widget-large uk-container-small uk-flex uk-flex-center uk-flex-middle" onclick="changeLarge()">
    <div class="uk-flex uk-flex-middle uk-width-1-1">
      <div class="uk-width-1-2 uk-text-center">
        <div class="uk-light uk-h5 uk-margin-remove-bottom uk-text-bold">¿Necesitas <br> ayuda?</div>
      </div>
      <div class="uk-width-1-2 uk-text-center">
        <a href="https://web.whatsapp.com/send?phone=51946037096" target="_blank">
          <img src="/pages/whatsapp.png">
          <div class="">
            <span class="uk-light uk-h6 uk-margin-remove-bottom uk-text-bold">(+51) 946 037 096</span>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  var flagS = true
  var flagLarge = true

  function changeSmall () {
    if (flagS) {
      $('#isee-hidden').addClass('active')
      flagS = false
     } else {
      $('#isee-hidden').removeClass('active')
      flagS = true
    }
  }

  function changeLarge () {
    if (flagS) {
      $('#isee-visible').addClass('hover')
      flagS = false
     } else {
      $('#isee-visible').removeClass('hover')
      flagS = true
    }
  }
</script>
