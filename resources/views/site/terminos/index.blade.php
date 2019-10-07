@push('css')
  <link rel="stylesheet" href="/css/site/pages/shop.css">
@endpush

@extends('layouts.site')

@section('content')

  <div class="uk-section uk-background-cover uk-background-default">
    <div class="uk-section-small uk-padding-remove-bottom">
      <div class="uk-container uk-container-small">
        <div class="uk-h1 uk-text-center isee-bold isee-spacing-small">
          @lang('terms.terms')
        </div>
      </div>
    </div>
  </div>

  <div class="uk-section uk-padding-remove-top">
    <div class="uk-container uk-container-small">
      <div class="">
        <ul class="uk-list uk-h5">
          <li><a class="uk-link-reset" href="#list1" uk-scroll="offset: 100">@lang('terms.list1')</a></li>
          <li><a class="uk-link-reset" href="#list2" uk-scroll="offset: 100">@lang('terms.list2')</a></li>
          <li><a class="uk-link-reset" href="#politica" uk-scroll="offset: 100">@lang('terms.list3')</a></li>
          {{-- <li><a href="#list4" uk-scroll="offset: 100">@lang('terms.list4')</a></li> --}}
          <li><a class="uk-link-reset" href="#list5" uk-scroll="offset: 100">@lang('terms.list5')</a></li>
        </ul>
      </div>
      <div id="list1" class="">
        <div class="uk-h3 uk-text-bold"> @lang('terms.list1')</div>
        <div class="uk-text-justify">
          <ul class="uk-list">
            <li>
              <p class="uk-text-bold">1. LA EMPRESA</p>
              <ul class="uk-list-bullet">
                <li>I see glasses, es nuestra razón comercial y somos una empresa peruana registrada en los registros públicos de la ciudad de Lima con numero de partida registral 12982824.</li>
                <li>I see glasses, opera en el mercado nacional e internacional mediante la página web, www.isee-glasses.com (en adelante, la “Página Web").</li>
              </ul>
            </li>
            <li>
              <p class="uk-text-bold">2. ÁMBITO DE APLICACIÓN</p>
              <ul class="uk-list-bullet">
                <li>Las presentes condiciones de compra se aplicarán a todos los pedidos de lentes realizados a través de la web www.isee-glasses.com</li>
                <li>Estas Condiciones constituyen las únicas condiciones aplicables a las compras realizadas a través de la Página Web y en ningún caso será de aplicación cualquier otro término y/o condición.</li>
                <li>Mediante la marcación de la casilla "Acepto los Términos y Condiciones” del formulario de pedidos, Ud. acepta y se compromete al cumplimiento de estas Condiciones.</li>
                <li>I see glasses, se reserva el derecho de modificar estas Condiciones en cualquier momento y sin previo aviso. No obstante, dichos cambios no tendrán efecto alguno sobre los pedidos realizados con anterioridad a la modificación de las Condiciones de la Página Web.</li>
              </ul>
            </li>
            <li>
              <p class="uk-text-bold">3. SU ESTATUS</p>
              <ul class="uk-list-bullet">
                <li>Ud. confirma que es una persona física y que realiza el pedido en calidad de consumidor, que es mayor de edad y que es legalmente capaz para contratar.</li>
              </ul>
            </li>
            <li>
              <p class="uk-text-bold">4. REGISTRO DEL USUARIO</p>
              <ul class="uk-list-bullet">
                <li>Para realizar un pedido a I see glasses, Ud. deberá registrarse como cliente mediante la
                  indicación de su cuenta de correo electrónico como ID de usuario y una contraseña, así como el
                  domicilio de facturación y de envío, el teléfono de contacto y su fecha de nacimiento. Así mismo
                  Ud. podrá registrarse en la Página Web como usuario en cualquier momento sin necesidad de
                  realizar un pedido</li>
                <li>Una vez creada la cuenta de usuario, Ud. podrá subir una fotografía que le permitirá probar las
                  gafas sobre su propia imagen. Ud. podrá eliminar la fotografía en cualquier momento. Sólo se
                  podrán subir fotos que no violen los derechos de autor, derechos personales o cualquier otro
                  derecho de terceros.</li>
                <li>Ud. será responsable de mantener la contraseña y los datos de su cuenta de usuario en secreto.
                  La contraseña es confidencial y no podrá compartirse con terceros. Tenga Ud. en cuenta que un
                  tercero que conozca su contraseña será capaz de hacer pedidos en su nombre. Si Ud. olvidara sus
                  datos de acceso, Ud. podrá solicitar a I see glasses el envío de una nueva contraseña.</li>
                <li>I see glasses no se hace responsable por los daños causados por el mal uso o pérdida de la
                  contraseña.</li>
              </ul>
            </li>
            <li>
              <p class="uk-text-bold">5. FORMALIZACIÓN DE LA COMPRA</p>
              El proceso de compra se realiza mediante los siguientes pasos:
              <ul class="uk-list-bullet">
                <li>El proceso de compra se inicia con la selección del modelo de lentes y las especificaciones
                  posibles en cuanto al color de la montura, forma y color de las lunas y los parámetros ópticos.</li>
                <li>Si Ud. lo desea y así lo indica haciendo clic en la opción “Guardar”, I see glasses guardará, por un
                  periodo de tiempo razonable, los datos ópticos que Ud. introduzca durante el proceso de compra
                  si previamente Ud. se hubiera registrado como cliente.</li>
                <li>Posteriormente, Ud. deberá completar el formulario de pedido indicando el domicilio de entrega
                  de los lentes y los datos de pago, entre otros datos. Estas indicaciones se simplifican en el caso de
                  que Ud. se haya registrado previamente como cliente. El pago podrá realizarse mediante tarjeta
                  de crédito o débito aceptadas por nuestra web.</li>
                <li>Una vez confirmada la orden de pago con cargo a su tarjeta de crédito y/o débito y comprobarse
                  la efectividad de dicha orden, I see glasses le enviará un correo electrónico confirmándole su
                  compra.</li>
                <li>Al momento de enviarle su producto, se le enviara el comprobante de compra respectivo.</li>
              </ul>
            </li>
            <li>
              <p class="uk-text-bold">6. PRECIOS</p>
              <ul class="uk-list-bullet">
                <li>Los precios serán los que se establezcan en la página web, salvo en caso de error manifiesto.</li>
                <li>Los precios están en expresados en soles para el territorio peruano y en dólares americanos para
                  cualquier país fuera del Perú.</li>
                <li>I see glasses, podrá modificar los precios en cualquier momento anterior a recibir la solicitud de
                  su pedido.</li>
                <li>Los servicios serán prestados por parte de I see glasses una vez se haya confirmado la compra y
                  se haya procedido al pago.</li>
              </ul>
            </li>
            <li>
              <p class="uk-text-bold">7. DEVOLUCIÓN DEL PRODUCTO Y GARANTÍA DEL 100%</p>
              <ul class="uk-list-bullet">
                <li>Para cancelar la solicitud de compra, Ud. deberá informar a I see glasses por escrito a través de la
                  siguiente dirección: service@isee-glasses.com</li>
                <li>Si Ud. decidiera anular su pedido después de haber recibido los lentes, Ud. podrá obtener el
                  reembolso del importe del producto siempre que:
                  <ul class="uk-list">
                    <li>i. Comunique su decisión a I see glasses dentro de los treinta (5) días naturales posteriores a la
                      fecha de entrega del producto mediante mensaje dirigido a las direcciones antes indicadas;</li>
                    <li>ii. Ud. devuelva a I see glasses las gafas en perfecto estado y en su estuche original, remitiéndolas
                      a su costa y bajo su responsabilidad por correo certificado a la dirección que le facilitaremos una
                      vez haya contactado con nosotros.</li>
                  </ul>
                </li>
                <li>La Garantía 100% se aplica exclusivamente al producto inicialmente recibido, no siendo posible el
                  reembolso o modificación de ulteriores modificaciones del pedido inicial, así como los casos en los
                  que existe un error por parte del cliente a la hora de introducir los datos de su graduación o
                  cuando éste no nos haya facilitado su receta oftalmológica dentro de su pedido.</li>
                <li>Esta disposición no afecta a los derechos establecidos por ley que pudieran afectarle.</li>
                <li>Si su pedido no ha llegado a su hogar pasados 30 días desde la fecha de envío, puede contactar
                  con nosotros enviando un email a service@isee-glasses.com para reclamar el pedido. En ese
                  momento le ofreceremos la posibilidad de escoger entre reactivar y refabricar su pedido o bien
                  anular el mismo y proceder al reembolso del importe pagado.</li>
              </ul>
            </li>
            <li>
              <p class="uk-text-bold">8. LIMITACIÓN DE LA RESPONSABILIDAD</p>
              <ul class="uk-list-bullet">
                <li>La responsabilidad por las pérdidas que pudiera Ud. sufrir como consecuencia de incumplimiento
                  del Contrato por parte de I see glasses, se limitará estrictamente al importe que Ud. hubiera
                  pagado por el servicio.</li>
                <li>No obstante, la limitación anterior no será de aplicación a lo siguiente:
                  <ul class="uk-list">
                    <li>(a) Por fallecimiento o lesiones personales provocadas por negligencia debida a nosotros;</li>
                    <li>(b) Por dolor y / o negligencia grave.</li>
                    <li>(c) Por fraude o falsedad, o</li>
                    <li>(d) En cualquier otro caso que fuera ilegal el excluir, o intentar excluir, nuestra responsabilidad.</li>
                  </ul>
                </li>
              </ul>
            </li>
            <li>
              <p class="uk-text-bold">9. PROTECCIÓN DE DATOS</p>
              <ul class="uk-list-bullet">
                <li>Los datos personales que Ud. nos ha facilitado por medio del formulario de pedidos y su historial
                  de compra, los conservaremos en un fichero propiedad de I see glasses, cuyos datos corporativos
                  han sido indicados al comienzo de las presentes Condiciones, con la finalidad de poder atender su
                  compra.</li>
                <li>Solo conservaremos sus datos ópticos si Ud. pulsa el botón “Guardar” en la Página Web,
                  conservándolos junto con la información en su cuenta de usuario y facilitándole el acceso a los
                  mismos cada vez que se identifique en la Página Web.</li>
                <li>Además le informamos de que Ud. tiene el derecho de acceso, rectificación, cancelación y
                  oposición de sus datos mediante escrito dirigido a la siguiente dirección: service@isee-glasses.com</li>
              </ul>
            </li>
            <li>
              <p class="uk-text-bold">10. GENERAL</p>
              <ul class="uk-list-bullet">
                <li>I see glasses podrá transferir, ceder, gravar, subcontratar o disponer del contrato, o de
                  cualquiera de sus derechos u obligaciones derivados del mismo, en cualquier momento durante la
                  vigencia del Contrato.</li>
                <li>La declaración de nulidad o invalidez por un Tribunal o un Árbitro de cualquier término,
                  condición o párrafo de este contrato no afectará a la validez o eficacia del resto del Contrato.</li>
                <li>Estas Condiciones se regirán e interpretarán de acuerdo con el Derecho Peruano. La resolución
                  de todas las cuestiones litigiosas derivadas de las presentes Condiciones, o relativas al
                  incumplimiento, interpretación, resolución o validez de cualquier disposición de las presentes
                  Condiciones, las partes, de común acuerdo, se someten al fuero y jurisdicción de los Juzgados y
                  Tribunales de Lima, con renuncia expresa a cualquier otro fuero que en su caso pudiera
                  corresponderles.</li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div id="list2" class="">
        <div class="uk-h3 uk-text-bold"> @lang('terms.list2')</div>
        <p class="uk-text-justify">
          Nosotros en I see glasses, respetamos la privacidad de tu información personal, y nos
          comprometemos para asegurar que tu información este protegida y permanezca en estatus de
          privada.</p>
        <p class="uk-text-justify">
          Esta política describe como nosotros usamos tu información personal, la cual recibimos y
          almacenamos en conexión con el uso de nuestra página web www.isee-glasses.com.</p>
        <p class="uk-text-justify">
          Asimismo indicar que nosotros como empresa no somos los que alojamos nuestra página web,
          todo el tema del hosting es proporcionado como un servicio por un tercero, a cuya empresa
          nosotros contratamos para tal fin. Esto significa que la información personal o cualquier otra
          información que usted nos proporciona es almacenada en los servidores de estas empresas, cuyos
          servidores pueden estar alojados en cualquier parte del mundo. Asi que por favor tenga presente
          que usted esta consintiendo que su información sea transferida a empresas de terceros alrededor
          del mundo y que proveen este servicio de alojamiento de nuestro sitio web.</p>
        <div class="uk-text-justify">
          <ul class="uk-list">
            <li>
              <p class="uk-text-bold">1. INTRODUCCIÓN</p>
              <p>Nuestra política de privacidad explica nuestras prácticas de información online y las alternativas
                que usted puede tomar con respecto a la manera en que su información personal es recolectada y
                usada en conexión con nuestro sitio web. Cuando hablamos de “Información personal” nos
                referimos a cualquier tipo de información que pueda ser usada, ya sea sola o en combinación con
                otra información, para personalmente identificar a un individuo, incluyendo el nombre y apellido,
                un perfil personal, una dirección de email, una dirección física o de casa u otra información de
                contacto.</p>
              <p>La información personal que usted nos proporciona, no será vendida, alquilada, o comercializada
                de ninguna forma a nadie. Nosotros no proporcionaremos su información a ningún tercero, a
                excepción que se especifique en esta política y excepto si tal divulgación de información sea
                solicitada por las autoridades del gobierno o de acuerdo a las leyes correspondientes.</p>
            </li>
            <li>
              <p class="uk-text-bold">2. TÉRMINOS DE USO</p>
              <p>Nuestra política de privacidad forma parte de nuestros “Términos y condiciones de uso general” el
                cual está disponible en nuestra página web: www.isee-glasses.com</p>
            </li>
            <li>
              <p class="uk-text-bold">3. CONSENTIMIENTO Y MODIFICACIÓN DE POLÍTICA</p>
              <p>Usted no está obligado a proporcionarnos su información personal, y si nos provee dicha
                información personal, mediante esta política usted confirma que está realizando dicho acto bajo
                su libre decisión. En el momento que usa nuestro sitio web, usted confirma que está de acuerdo
                con nuestros términos y condiciones de nuestra política de privacidad y a la forma en que
                recolectamos, procesamos y compartimos su información personal para los propósitos que se
                detallan en los párrafos siguientes. Si usted no está de acuerdo con nuestra política de privacidad,

                por favor no acceda o use nuestros sitios web. Nosotros nos reservamos el derecho, a nuestra
                discreción, de cambiar la política de privacidad en cualquier momento y de tiempo en tiempo.
                Cualquier cambio se hará efectivo en el mismo momento de haber publicado en nuestro sitio web
                la política de privacidad revisada y modificada, y su continuidad en el uso de nuestro sitio web
                después de ello, indicara que usted acepta dichos cambios.</p>
            </li>
            <li>
              <p class="uk-text-bold">4. CONFIDENCIALIDAD, PROTECCIÓN DE DATOS Y USO DE COOKIES</p>
              <ul class="uk-list uk-list-bullet">
                <li>Su privacidad es respetada</li>
                <li>Los formularios de inscripción son seguros</li>
                <li>La información aportada no se revela a terceros</li>
                <li>Los seguimientos estadísticos de nuestra página se realizan desde el absoluto anonimato y
                  confidencialidad.</li>
                <li>Por razones de ética y de seguridad, no se envía ningún dato acerca de su salud por correo
                  electrónico. Si ha enviado información por correo electrónico, está se mantendrá al mismo nivel
                  de seguridad y privacidad, pudiendo usted de manera exclusiva acceder a ella y pedir su
                  cancelación en cualquier momento.</li>
                <li>Los datos personales que Ud. nos facilite por medio del formulario de pedidos y su historial de
                  compra los conservaremos en un fichero propiedad de I see glasses con la finalidad de atender su
                  compra.</li>
                <li>Además le informamos de que Ud. tiene el derecho de acceso, rectificación, cancelación y
                  oposición de sus datos mediante escrito dirigido a la siguiente dirección: service@isee-glasses.com.</li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div id="politica" class="">
        <div class="uk-h3 uk-text-bold"> @lang('terms.list3')</div>
        <p class="uk-text-justify">
          En I see glasses, los envíos son gratuitos a todo el mundo. Si pide dos pares de lentes, por ejemplo,
          debe saber que las mismas se enviarán por separado, con sus respectivos estuches de protección.
          El plazo de entrega depende de muchos factores como el tipo de lunas que ha adquirido, el grado
          de medidas de su prescripción, el sitio donde se ubica el lugar de envío entre otros factores.</p>
        <ul class="uk-list uk-list-bullet">
          <li>Después de la fabricación de sus lunas a medida, los lentes son inmediatamente empaquetados y
            enviados por correo. La manera más rápida, cómoda y segura.</li>
          <li>La entrega de su pedido se lleva a cabo de forma segura por correo. Es usted quien decide el
            lugar de entrega, ya sea su domicilio o lugar de trabajo.</li>
          <li>Además, nuestro precio único todo incluido incluye también una garantía de perfecta entrega del
            pedido, responsabilizándonos de los posibles daños causados durante su transporte. Si usted ha
            ordenado varios pares de gafas al mismo tiempo, recibirá cada uno en un paquete separado.</li>
          <li>Para la fabricación de las lunas, nos tomamos el tiempo que sea necesario para entregarle un
            producto de calidad. A continuación le detallamos los tiempos de fabricación y envío aproximados:
          </li>
        </ul>
        <div class="" uk-grid>
          <div class="uk-width-1-2 uk-overflow-auto">
            <div class="uk-text-bold uk-text-center">
              TIEMPO DE PRODUCCIÓN
            </div>
            <table class="uk-table uk-table-divider uk-table-small">
              <thead>
                <tr>
                  <th class="uk-text-center">Tipo de lunas</th>
                  <th class="uk-text-center">Tiempo de procesamiento</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Visión simple - Medida regular</td>
                  <td>3 días laborables</td>
                </tr>
                <tr>
                  <td>Visión simple - Medida alta (*)</td>
                  <td>4 días laborables</td>
                </tr>
                <tr>
                  <td>Multifocal (Progresivos)</td>
                  <td>6 días laborables</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="uk-width-1-2 uk-overflow-auto">
            <div class="uk-text-bold uk-text-center">
              TIEMPO DE ENVÍO
            </div>
            <table class="uk-table uk-table-divider uk-table-small">
              <thead>
                <tr>
                  <th class="uk-text-center uk-width-medium">Envío a</th>
                  <th class="uk-text-center ">Tiempo envío</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Lima Metropolitana</td>
                  <td>2 a 3 días laborables</td>
                </tr>
                <tr>
                  <td>Perú nivel nacional (excepto Lima Metropolitana)</td>
                  <td>3 a 5 días laborables</td>
                </tr>
                <tr>
                  <td>Países internacionales</td>
                  <td>15 a 20 días laborables</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <p class="uk-text-justify">
          Tomar nota:
          <ul class="uk-list">
            <li>- (*) medidas altas se refieren a prescripciones con Esferas mayores de +/- 6.00 o Cilindros mayores de +/-3.00</li>
            <li>- Lentes con lunas Transitions requerirán días adicionales para su producción</li>
            <li>- Si su prescripción está incompleta o tenemos preguntas acerca de su orden, incluida la prescripción, usted será notificado y esto provocará retrasos en el tiempo de producción de sus lentes</li>
            <li>- Todos los envíos internacionales están sujetos a impuestos de importación.</li>
          </ul>
          Si su paquete no ha llegado a su hogar pasados 30 días desde la fecha de envío, puede contactar con nosotros enviando un email a service@isee-glasses.com para reclamar su pedido. En ese momento le ofreceremos la posibilidad de escoger entre reactivar y refabricar su pedido o bien anular el mismo y proceder al reembolso del importe pagado.
          En caso de retraso, no dude en contactar con nosotros vía whatsapp al (+511) 981 338 792
        </p>
      </div>
      <div id="list5" class="uk-text-justify">
        <div class="uk-h3 uk-text-bold"> @lang('terms.list5')</div>
        <p>Acceder a esta garantía es muy sencillo, I see glasses le propone una garantía que incluye un plazo de 5 días
          durante los cuales usted podrá probar sus lentes sin ningún compromiso.</p>
        <p>I see glasses se compromete a respetar las garantías legales en lo que se refiere a defectos de fabricación.
          Además, nos comprometemos a la garantía "100% satisfecho o te reembolsamos tu dinero". Para tal efecto, el cliente
          reconoce que las fotos de los productos en la página web no son contractuales y que la conformidad se evaluará atendiendo
          a los criterios de modelo, color y corrección registrados en el pedido validado del cliente.</p>
        <p>El cliente se beneficia también de la garantía legal en lo referido a defectos de fabricación.</p>
        <p>Para hacer uso de la Garantía 100% y llevar a cabo el proceso de devolución el cliente debe haber
          adjuntado la receta y la foto para la Distancia Pupilar a su pedido. En ausencia de estos elementos,
          el cliente reconoce que I see glasses se reserva el derecho a no proceder al reembolso ni a un
          cambio, sin incurrir en responsabilidad.</p>
        <p>Para hacer uso de la Garantía 100% satisfacción, debe antes de nada contactar con nuestro
          servicio de atención al cliente (service@isee-glasses.com) y devolvernos el pedido dentro de 5 días
          (a contar desde la fecha de entrega del producto), a la dirección que le será facilitada en respuesta
          a su solicitud.</p>
        <p>El paquete a devolver debe contener:
          <ul class="uk-list uk-list-bullet">
            <li>El producto en el estado en el que el cliente lo recibió con todos los elementos (embalaje,
              instrucciones, accesorios, documentación, etc.). Cualquier producto que presente la muestra de
              un uso más allá de la simple prueba por parte del cliente no dará lugar a cambio o devolución.</li>
            <li>La factura de compra con el número de pedido para una gestión óptima.</li>
            <li>Los gastos de envío para la devolución del paquete corren por cuenta del cliente, en virtud de
              nuestras Condiciones Generales de Venta.</li>
            <li>En ausencia de alguno de estos elementos, I see glasses se reserva el derecho a no proceder con
              ninguna devolución de dinero, sin incurrir en responsabilidad alguna.</li>
            <li>El cliente reconoce estar informado que la garantia 100% se aplica únicamente al producto
              inicialmente recibido y sólo por una vez.</li>
          </ul>
        </p>
        <p>AVISO IMPORTANTE: la Garantía 100% se aplica exclusivamente al producto inicialmente recibido,
          no siendo posible el reembolso o modificación de ulteriores modificaciones del pedido inicial, así
          como los casos en los que existe un error por parte del cliente a la hora de introducir los datos de
          su graduación cuando éste no nos haya facilitado la receta oftalmológica dentro de su pedido.
          Para más información, por favor, lea detenidamente nuestras Condiciones Generales de Venta.</p>
      </div>
    </div>
  </div>

@endsection

@push('js')
  <script>
  var path = window.location.href.split('#')
  if (path[1]) {
    UIkit.scroll($('<a></a>'), { offset: 110 }).scrollTo("#"+path[1]);
  }
  </script>
@endpush
