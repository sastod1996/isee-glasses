@push('css')
  <link rel="stylesheet" href="/css/site/pages/faq.css">
@endpush

@extends('layouts.site')

@section('content')

  <div class="uk-section uk-background-cover uk-background-default">
    <div class="uk-section-small uk-padding-remove-bottom">
      <div class="uk-container uk-container-small">
        <div class="uk-h1 uk-text-center isee-bold isee-spacing-small">
          @lang('faq.title')
        </div>
      </div>
    </div>
  </div>

  <div class="uk-section uk-section-xsmall">
    <div class="uk-container">
      <ul class="uk-list">
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">@lang('faq.pregunta1')</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                @lang('faq.respuesta1')
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿CÓMO MEDIR MI DISTANCIA PUPILAR?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <div>
                Atención, es muy importante incluir correctamente su distancia interpupilar,
                ya que, de lo contrario, los lentes no se adaptarán perfectamente a su vista.
                Si no conoce su distancia interpupilar o no se encuentra incluida en su receta
                bajo el nombre de "DP, DNP, DIP, Distancia de los centros...",
                no dude en contactar con su oftalmólogo, el cual le dará sus medidas.
              </div>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Cómo puedo saber en qué situación se encuentra el pedido de mis lentes?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <div>
                Al realizar su pedido le enviamos un email de confirmación donde se adjunta un link que lo
                lleva a su cuenta y donde podrá ver el estatus de todos sus pedidos.
                También puede ingresar directamente a su cuenta en nuestra pagina web y ver el estado
                de su pedido.
                Asimismo, cada vez que sus lentes pasan a una siguiente etapa dentro del proceso de
                fabricación, nosotros le enviamos un email en forma automática informándole de este
                cambio de estado de su pedido.
                Por último y si así lo desea, también podrá contactarnos vía nuestra página web, email o
                whatsapp.
              </div>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Cómo saber si un par de gafas me van bien?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Justo hemos desarrollado nuestro Probador de gafas virtual para que usted
                pueda saber inmediatamente si las gafas le quedan bien,
                mediante la activación de su cámara web. El probador de gafas virtual lo encontrará
                en cada una de las gafas del catálogo.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Todo el mundo puede comprar en isee-glasses.com?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Sí, nosotros somos una página internacional y por eso mismo realizamos envíos a cualquier parte del mundo totalmente gratis.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Puedo comprar lentes de sol con lunas de medida?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Todos los lentes de sol que vendemos se venden sin lunas de medida. Es por esta razón
                que hemos desarrollado un servicio adicional para que a todos sus lentes oftálmicos con
                sus lunas de medida se les pueda hacer un tratamiento adicional y tengan la apariencia de
                unos lentes de sol. Al comprar sus lentes, vaya a la sección de compra de “Puedes darle
                características adicionales a tus lentes” donde podrá adquirir estos servicios que necesita y
                donde le explicaremos los beneficios de los mismos.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Cuáles son las señales indicadoras de la miopía?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Si sientes cansancio en los ojos, tienes dolores de cabeza y arrugas los ojos a la hora de leer algo desde cierta distancia para enfocar mejor. Si para enfocar tienes que estar parpadeando para enfocar mejor o si durante la noche notas sobre todo mientras conduces que no distingues nada, y se te mezclan las luces con los semáforos y los reflejos, es una señal de miopía clara.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Cuáles son las señales indicadoras de la presbicia?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Si al leer debes sostener lo que lees a una distancia mayor que el largo del brazo. Y tienes dificultad para leer letras pequeñas y ver los objetos cercanos. Dolores de cabeza y fatiga visual.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Puedo comprar mis gafas utilizando la receta de mis lentes de contacto?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Nosotros le recomendamos que utilice una receta distinta para cada cosa: una receta para sus gafas y otra para sus lentes de contacto, ya que, más allá de una cierta corrección de la visión, las competencias son diferentes.
              </p>
            </div>
          </div>
        </li>
        <li id="como-hacer-para-prolongar-la-duracion-de-tus-gafas-oftalmicas" class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Cómo hacer para prolongar la duración de tus gafas oftálmicas?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <ul class="uk-list">
                <li class="uk-margin">
                  Utiliza un estuche protector tipo cofre cuando no los estes utilizando
                  <p>
                    Evita dejar tus lentes sobre cualquier tipo de superficie sin este protector, esto protegerá tus lentes de las ralladuras y prolongarás el uso de los mismos ahorrándote dinero.
                  </p>
                </li>
                <li class="uk-margin">
                  Utiliza ambas manos para retirarte tus gafas al momento de dejarlas de usar
                  <p>
                    Evita quitarte tus gafas con una sola mano, dado que esto hace que los brazos de las gafas se descuadren y por lo tanto ya no te van a quedar firmes y mucho menos alineadas para que puedas tener una buena visión con ellas.
                  </p>
                </li>
                <li class="uk-margin">
                  No utilices tus gafas en la parte de encima de la cabeza
                  <p>
                    Aunque las gafas puedan sentirse firmes en esta zona de tu cabeza y lo utilices momentáneamente para sostener tus gafas mientras realizas otra actividad, trata de no hacerlo, dado que esto hace que los brazos de las gafas se descuadren.
                  </p>
                </li>
                <li class="uk-margin">
                  No limpiar tus lentes con algodón, papel toalla o tissue
                  <p>
                    Cuando tengas la necesidad de limpiar los lentes de tus gafas, evita utilizar tus prendas de vestir. Tanto la ropa, papel toalla o los tissues son demasiados ásperos para limpiar tus lentes y los van a rayar. Usa la tela microfibra que I see glasses te incluye gratuitamente por la compra de tus gafas.
                  </p>
                </li>
                <li class="uk-margin">
                  No dejes tus lentes dentro del auto expuestos directamente a los rayos del sol
                  <p>
                    Los rayos de sol que reflejan a través de las ventanas del auto pueden dañar tus lentes si les dan directamente, haciendo que no veas correctamente. Aún más, si tus gafas son de plástico, estas se pueden ablandar por el calor del sol y no te quedarán de la misma manera.
                  </p>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">TENGO UNA DUDA SOBRE MI PEDIDO, ¿ME PUEDEN AYUDAR?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Si, por supuesto. Te puedes comunicar con nosotros a través de nuestro email o por nuestro whatsapp.
                Tras la recepción, haremos todo lo que sea necesario para ayudarle.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿CÓMO SABER SI MI PEDIDO HA SIDO PROCESADO?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Cuando usted envía su solicitud, nosotros la validamos y le enviamos un correo electrónico de
                confirmación de forma automática con el resumen del pedido. Si usted no recibe este correo electrónico,
                por favor contáctenos a nuestro email o a nuestro número de whatsapp.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Qué pasa si al recibir mi pedido mis lentes no me quedan como yo pensaba?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Recuerde que con nosotros tiene 100% de garantía de satisfacción de compra.
                Simplemente contáctenos dentro del plazo de 7 días desde la recepción del producto.
                Todos los productos a devolver deben ser nuevos, sin uso, con su embalaje original
                perfectamente intacto y acompañado de su comprobante de compra. Al momento de su
                solicitud de devolución, le proporcionaremos un formato que deberá completar y enviar
                de regreso para proceder con la devolución del 100% de su dinero.
              </p>
            </div>
          </div>
        </li>
        <li id="como-funciona-el-probador-de-gafas-virtual" class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Cómo funciona el probador de gafas virtual?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Con nuestro probador de gafas virtual puedes probarte
                todos los modelos que quieras y los pasos a seguir son simples:
              </p>
              <p>
                <ul class="uk-list">
                  <li class="uk-margin">
                    Escoge las gafas que más te gusten: Tenemos una enorme variedad de gafas para que puedas escoger la que más te guste según la ocasión, según la forma de tu rostro, etc.
                  </li>
                  <li class="uk-margin">
                    Darle clic al icono Probador de gafas virtual: Una vez que escogiste la gafa que más te gusta, en la esquina superior izquierda de cada una de ellas busca el icono de nuestro Probador de gafas virtual y darle clic.
                  </li>
                  <li class="uk-margin">
                    Activa tu cámara web: y ve cómo te quedan.También si lo deseas puedes subir una fotografía desde tu equipo.
                  </li>
                </ul>
              </p>
              <p>
                ¡Pruébate todas las gafas que desees y disfruta de tu compra!
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Qué formas de pago me permite isee-glasses.com?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Aceptamos pagos en línea con tarjetas de crédito, débito y prepagadas de las marcas Visa,
                Mastercard, Diners Club y American Express.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Ofrece ISEE lentes fotosensibles o fotocromáticas?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Sí, ofrecemos gafas fotocromáticas que se oscurecen en función de la luz y le ofrecen un confort total en cualquier circunstancia. Usted puede comprar cristales fotocromáticos en marrón o gris para todas las monturas propuestas. Al comprar podrá seleccionarlo como una característica adicional e informarse más sobre esta.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Cuáles son las señales indicadoras de la hipermetropía?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                El principal síntoma de la hipermetropía es la visión borrosa de los objetos cercanos, aunque esta señal puede no aparecer o atenuarse si el paciente es joven y conserva su capacidad de acomodación. Otros indicadores son dolor de cabeza, dolor de ojos, fatiga ocular. Son más frecuentes por la noche y después del trabajo. Cuando la hipermetropía es aguda, se aprecia desde la infancia. A menudo va acompañada de un estrabismo que debe corregirse rápidamente.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Necesito una receta óptica para unas gafas de descanso?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Si usted se siente más cómodo sí, deberá consultar a su oftalmólogo. Éste le hará una evaluación y determinará la prescripción que usted necesita.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿POR QUÉ MI DISTANCIA PUPILAR ES TAN IMPORTANTE?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                La distancia interpupilar es la que garantiza que los lentes sean colocados de modo que
                sus centros ópticos coincidan perfectamente con los ejes visuales de cada ojo.
                Cuando esto no ocurre provoca un efecto prismático que provocaría molestias como visión borrosa
                o dolores de cabeza. Si las pupilas son simétricas a ambos lados de la nariz,
                el óptico puede dar una distancia total PD, de lo contrario, será necesario medir por separado
                cada "semi-distancia pupilar" MPD y LPD desde el centro de la nariz (Por ejemplo,
                se dice que las distancias son de 32 y 31.5, o que la distancia total es de 63,5).
                La DP es especialmente importante a la hora de montar las lentes progresivas,
                o con graduaciones muy altas. En monofocales o lentes con graduación bajas también es importante,
                pero existe un mayor margen de tolerancia.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">Mi pedido está en camino. ¿Qué significa eso?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Esto significa que sus gafas ya están fabricadas y que se encuentran en camino
                entre nuestras oficinas y su domicilio.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Puedo conservar mis antiguas monturas y hacer un pedido sólo de lentes?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Lamentablemente solo ofrecemos el producto completo de montura y lentes.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">Refiere a un amigo</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Puedes compartir con tus amigos todos los modelos que te gusten, para lo cual tienes las siguientes opciones:
              </p>
              <p>
                <ul class="uk-list">
                  <li class="uk-margin">
                    Desde el catálogo de gafas
                    <p>
                      En la parte superior de cada modelo de gafa desde el catálogo de productos aparece el símbolo de Facebook. Dando clic en este icono puedes compartir cualquier modelo que te guste con todos los amigos que desees en Facebook.
                    </p>
                    <p>

                    </p>
                  </li>
                  <li class="uk-margin">
                    Desde tu lista de deseos
                    <p>
                      En la parte superior derecha de nuestra página web se encuentra el logo de un corazón, al dar clic a este logo accedes a tu lista de deseos.
                    </p>
                    <p>

                    </p>
                    <p>
                      En tu lista de deseos ubica el botón “Compartir” y nuestro sistema te brinda dos opciones para poder compartir tu lista de deseos, la primera es a través de Facebook y la segunda opción es mediante mensaje al email de otra persona
                    </p>
                    <p>

                    </p>
                  </li>
                </ul>
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Puedo comprar gafas no graduadas?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Si es posible, usualmente son usadas como accesorios de moda. Elige la opción "sin medida" cuando selecciones el tipo de gafas que necesitas.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Cuándo se necesitan gafas?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                En general, los científicos suponen que la vista por defecto puede ser compensada hasta 0,5 dioptrías en cada ojo, sin embargo, a ese nivel se recomienda ya usar gafas, ya que el ojo está mucho más relajado y existen muchos signos de fatiga que desaparecen después de una simple corrección.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Cuáles son las señales indicadoras del astigmatismo?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                La persona con astigmatismo suele confundir los símbolos parecidos como h, m y n, u 8 y 0. Combinado con la miopía o la hipermetropía, el astigmatismo puede provocar fatiga visual y dolores de cabeza.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¿Puedo utilizar mi receta oftalmológica, aunque ya no sea válida?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Si su visión se estabiliza, a la hora de renovar su par de gafas, puede utilizar una receta que tenga no más de tres años. Pero una receta válida suele ser necesaria para el reembolso de sus gafas. Por supuesto, si su solicitud no es válida, no habrá reembolso.
              </p>
            </div>
          </div>
        </li>
        <li class="uk-margin">
          <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted isee-bold">
              <p class="isee-h4 uk-text-justify uk-text-uppercase">¡No encuentro la respuesta a mi pregunta! ¿Qué hacer?</p>
            </div>
            <div class="uk-card-body uk-text-justify">
              <p>
                Si tiene alguna consulta, no dude en contactar con nosotros a nuestro correo electrónico o por whatsapp y le responderemos tan pronto como sea posible.
              </p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>

@endsection

@push('js')
  <script>
  var path = window.location.href.split('#')
  if (path[1]) {
    UIkit.scroll($('<a></a>'), { offset: 100 }).scrollTo("#"+path[1]);
  }
  </script>
@endpush
