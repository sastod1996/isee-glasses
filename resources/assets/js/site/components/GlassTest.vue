<template>
  <div id="glass-test">
    <div class="isee-background-gray">
      <div id="glass-test-options" class="uk-width-1-1">
        <div class="uk-text-center">
          <div class="uk-padding-large uk-padding-remove-bottom	">
            <span class="isee-h2 uk-text-bold">ELIGE UNA OPCIÓN</span>
          </div>
          <div class="uk-padding-large uk-grid-small uk-flex-center" uk-grid>
            <div class="uk-width-1-6"></div>
            <div class="uk-width-1-3">
              <div class="">
                <a id="open-camera">
                  <img src="/pages/producto/tomar-foto.png" alt="tomar-foto">
                </a>
              </div>
              <div class="uk-margin-small uk-text-bold">
                Tomar foto
              </div>
            </div>
            <div class="uk-width-1-3">
              <div id="upload" class="test-upload" title="Subir foto" uk-tooltip uk-form-custom>
                <input id="loadPhoto" type="file" accept="image/jpeg, image/png">
                <a type="button"  tabindex="-1">
                  <img src="/pages/producto/subir-foto.png" alt="subir-foto">
                </a>
              </div>
              <div class="uk-margin-small uk-text-bold">
                Subir foto
              </div>
            </div>
            <div class="uk-width-1-6"></div>
          </div>
        </div>
      </div>
      <div id="glass-take-photo" class="uk-width-1-1" style="display:none; height: 401px;">
        <div class="uk-padding-small uk-grid-small" uk-grid>
          <div class="uk-width-1-3">
            <div class="isee-h5">
              <a id="regresar" class="uk-link-reset">
                <span uk-icon="icon: chevron-left; ratio:2" ></span>
                Regresar
              </a>
            </div>
            <div class="uk-flex-middle">
              <div id="list" class="uk-padding uk-padding-remove-right isee-h5">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-auto">
                    <img src="/pages/producto/ic-3.png" alt="">
                  </div>
                  <div class="uk-width-expand">
                    Pon tu rostro en el centro
                  </div>
                </div>
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-auto">
                    <img src="/pages/producto/ic-2.png" alt="">
                  </div>
                  <div class="uk-width-expand">
                    Quitate los lentes
                  </div>
                </div>
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-auto">
                    <img src="/pages/producto/ic-4.png" alt="">
                  </div>
                  <div class="uk-width-expand">
                    Evita inclinar tu cabeza
                  </div>
                </div>
              </div>
              <div id="list2" class="uk-padding uk-padding-remove-right isee-h5" style="display:none;">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-auto">
                    <img src="/pages/producto/ic-1.png" alt="">
                  </div>
                  <div class="uk-width-expand">
                    Ubica los puntos verdes en tus ojos
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="uk-width-2-3">
            <div class="uk-text-center">
              <div class="uk-background-default">
                <div class="" uk-height-match="target: > div > div">
                  <div id="webcam" class="uk-padding-small uk-margin-auto">
                    <div class="" style="height: 261px;">
                      <video id="video"></video>
                    </div>
                  </div>
                  <div id="glasses-test" class="uk-padding-small uk-margin-auto" style="display:none;">
                    <div class="">
                      <canvas id="canvas" class="uk-margin-auto"></canvas>
                      <img hidden src="" id="photo" alt="photo">
                    </div>
                  </div>
                  <div class="uk-padding-small">
                    <div class="">
                      <a id="startbutton">
                        <img src="/pages/producto/tomar-foto.png" alt="tomar-foto" width="50" height="50">
                      </a>
                      <div class="isee-button">
                        <a id="tryGlasses" class="uk-link-reset uk-button uk-button-primary uk-light uk-button-large uk-text-bold" style="display:none">
                          PROBAR LENTES
                        </a>
                        <img ref="glassimage" hidden :src="glassImage" id="glasses" alt="glasses">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="dpi" ref="dpi"></div>
  </div>
</template>

<script>
export default {
  props: [
    'glassImage'
  ],
  computed: {
    imageHeight () {
      return this.$refs.glassimage.height
    },
    dpi () {
      return this.$refs.dpi.offsetWidth
    }
  },
  mounted () {

    var openCamera   = document.querySelector('#open-camera')
    var glassOptions   = document.querySelector('#glass-test-options')
    var glassTakePhoto   = document.querySelector('#glass-take-photo')
    var glassUploadPhoto   = document.querySelector('#glass-upload-photo')
    var regresar   = document.querySelector('#regresar')
    var video        = document.querySelector('#video')
    var startbutton  = document.querySelector('#startbutton')
    var tryGlasses   = document.querySelector('#tryGlasses')
    var glassesTest   = document.querySelector('#glasses-test')
    var loadPhoto   = document.querySelector('#loadPhoto')
    var upload        = document.querySelector('#upload')
    var list        = document.querySelector('#list')
    var list2        = document.querySelector('#list2')
    var photo        = document.querySelector('#photo')
    var webcam   = document.querySelector('#webcam')
    var canvas       = document.querySelector('#canvas')
    var ctx = canvas.getContext("2d")
    var streaming    = false
    var width = 355, height = 267

    $('#regresar').click(function() {
      glassOptions.style.display = 'block';
      glassTakePhoto.style.display = 'none';
      webcam.style.display = 'block';
      glassesTest.style.display = 'none'
      tryGlasses.style.display = 'none'
      list.style.display = 'block'
      list2.style.display = 'none'
    });

    $('#regresar2').click(function() {
      glassOptions.style.display = 'block';
      glassUploadPhoto.style.display = 'none';
      tryGlasses.style.display = 'none';
    });

    $('#open-camera').click(function() {
      width = 355, height = 267;
      glassOptions.style.display = 'none';
      glassTakePhoto.style.display = 'block';
      list.style.display = 'block';
      startbutton.style.display = 'block';

      var navigator = window.navigator

      navigator.getMedia = ( navigator.getUserMedia ||
                             navigator.webkitGetUserMedia ||
                             navigator.mozGetUserMedia ||
                             navigator.msGetUserMedia);

      navigator.getMedia(
        {video: true, audio: false},
        function(stream) {
          try {
            if (navigator.mozGetUserMedia) {
              video.mozSrcObject = stream;
            }else{
              var vendorURL = window.URL || window.webkitURL;
              video.src = vendorURL.createObjectURL(stream);
            }
            video.play();
          } catch (e) {
            // console.log('problem');
          }
        },
        function(err) {
          alert('Asegurate de activar tu cámara para usar el probador de lentes');
        }
      );

      video.addEventListener(
        'canplay',
        function(ev){
          if (!streaming) {
            height = video.videoHeight / (video.videoWidth/width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
          }},
        false
      );
    });

    $('#startbutton').click(function() {
      webcam.style.display = 'none';
      list.style.display = 'none'
      list2.style.display = 'block'

      takePhoto();
      tryGlasses.style.display = 'block'
      this.style.display = 'none'
    });

    loadPhoto.addEventListener(
      'change',
      function(ev){
        uploadPhoto(this);
        ev.preventDefault();
        this.value = "";
      },
      false
    );


    var x1 = 140, y1 = 90 //Posición inicial del punto 1
    var x2 = 210, y2 = 90 //Posición inicial del punto 2
    var arrastrar = false
    var id = 0 //1: cerca al punto 1  - 2: cerca al punto 2
    var tolerance = 5 //distancia de proximidad ('que tan cerca de ...')

    function showMessage(){
      // ctx.fillStyle="#222"; //color de relleno
      // ctx.fillRect(0, 250, width, 150);
      // ctx.fillStyle="#a6dd2c"; //color de relleno
      // ctx.font="13px arial"; //estilo de texto
      // ctx.fillText('* Ubica los puntos en la posición de tus ojos.',10,262);
    }

    function takePhoto() {
      canvas.width = width;
      canvas.height = height;
      ctx.drawImage(video, 0, 0, width, height);
      showMessage();

      var data = canvas.toDataURL('image/png');
      photo.setAttribute('src', data) ;
      drawEyes();
      document.getElementById('glasses-test').style.display = 'block';

    }

    function drawEyes(){
      var ctx = canvas.getContext('2d');
      ctx.fillStyle = "rgba(0,255,0,1)";
      ctx.beginPath();
      ctx.arc(x1, y1, 5, 0, Math.PI*2, true);
      ctx.fill();
      ctx.arc(x2, y2, 5, 0, Math.PI*2, true);
      ctx.fill();
    }

    // Obtener la posicion del mouse
    function getPosMouse(canvas, evt) {
      var rect = canvas.getBoundingClientRect();
      return {
          x: Math.round(evt.clientX - rect.left),
          y: Math.round(evt.clientY - rect.top)
      };
    }

    // Al presionar el ratón
    canvas.addEventListener("mousedown", function(evt) {
      // Obtener posicion del mouse
      var posMouse = getPosMouse(canvas, evt);
      // Dibujar puntos(ojos)
      drawEyes()
      // Si esta sobre algun punto
      if (ctx.isPointInPath(posMouse.x, posMouse.y)) {
        // Identificamos sobre que punto esta
        nearTo(posMouse.x, posMouse.y);
        arrastrar = true;
        // Si esta cerca al punto1(ojo izquierdo)
        if (id == 1) {
          // Actualizamos la posicion del punto1(ojo izquierdo)
          y1 = posMouse.y;
          x1 = posMouse.x;
        // Si esta cerca al punto2(ojo derecho)
        }else if (id == 2) {
          // Actualizamos la posicion del punto2(ojo derecho)
          x2 = posMouse.x;
          y2 = posMouse.y;
        }
      }
    }, false);

// Identificar si el puntero esta sobre el punto 1(izquierdo) o el punto 2(derecha)
  // Asigna id=1, si esta cerca al punto1(ojo izquierdo)
  // Asigna id=2, si esta cerca al punto2(ojo derecho)
    function nearTo(mouseX, mouseY){
      var dx1 = mouseX - x1;
      var dy1 = mouseY -y1;
      var distance1 = Math.abs(Math.sqrt(dx1*dx1+dy1*dy1));
      var dx2 = mouseX - x2;
      var dy2 = mouseY -y2;
      var distance2 = Math.abs(Math.sqrt(dx2*dx2+dy2*dy2));
      if (distance1 < tolerance) {
        id = 1;
      }else if (distance2 < tolerance) {
        id = 2;
      }
    }

    // Al mover el raton
    canvas.addEventListener("mousemove", function(evt) {
      var posMouse = getPosMouse(canvas, evt);
      // Si se activó "atrastrar"
      if (arrastrar) {
        // Limpiamos el canvas
        ctx.clearRect(0 ,0 ,canvas.width , canvas.height);
        // Volvemos a poner la foto
        ctx.drawImage(photo, 0, 0, width, height);
        showMessage();
        // Volvemos a calcular cerca a que punto esta
        nearTo(posMouse.x, posMouse.y);
        // Actualizamos las posiciones según el punto cercano al que se encuentre
        if(id == 1){
          x1 = posMouse.x;
          y1 = posMouse.y;
        }else if (id == 2) {
          x2 = posMouse.x;
          y2 = posMouse.y;
        }
        // Volvemos a dibujar los puntos(ojos)
        drawEyes();
      }
    }, false);

    // Si suelta el mouse
    canvas.addEventListener("mouseup", function(evt) {
      // Desactivamos el flag para atrastrar
      arrastrar = false;
    }, false);

    tryGlasses.addEventListener(
      'click',
      function(ev){
        setGlasses();
        ev.preventDefault();
      },
      false
    );

    function setGlasses(){
      // Guardamos los puntos
      var p1 = {x:x1, y:y1}
      var p2 = {x:x2, y:y2}
      // Limpiamos el canvas
      ctx.clearRect(0 ,0 ,canvas.width , canvas.height);
      // Volvemos a poner la foto
      ctx.drawImage(photo, 0, 0, width, height);
      showMessage();
      // Calculamos distancia de los puntos
      var dx = p2.x - p1.x // p1.x - p2.x;
      var dy = p2.y - p1.y // p1.y - p2.y;
      var dp = Math.abs(Math.sqrt(dx*dx+dy*dy)); //distancia entre puntos verdes
      var glasses = document.querySelector('#glasses');
      // console.log(glasses.width, glasses.height);
      // console.log("p1.x:" + p1.x + " p1.y: "+p1.y);
      // console.log("distancia: "+dp);

      // Distancia original entre los lentes
      // var dg = 172 // 10112017: 63 mm de distancia segun yuri
      // var wg = 330 // 10112017: 139 mm de ancho de los lentes segun yuri
      // var hg = 100 //glasses.height - 100 mm or default --> 35 mm muy pequeño
      // var pox = 310 //150 mm de distancia entre inicio y punto medio del lente en X
      // var poy = 290 //150 mm de distancia entre inicio y punto medio del lente en Y
      var dg = 59.53125 // 10112017: 63 mm de distancia segun yuri
      var wg = 119.0625 // 10112017: 139 mm de ancho de los lentes segun yuri
      // var hg = (this.imageHeight * 25.4) / this.dpi //glasses.height - 100 mm or default --> 35 mm muy pequeño
      var hg = 32.014583 //glasses.height - 100 mm or default --> 35 mm muy pequeño
      var pox = 120 //150 mm de distancia entre inicio y punto medio del lente en X
      var poy = 16.007292 //150 mm de distancia entre inicio y punto medio del lente en Y

      var rh = dg/hg; //proporcion de largo
      var rw = dg/wg; //proporcion de ancho
      var rpx = dg/pox; //proporcion de punto de inicio del lente en X
      var rpy = dg/poy; //proporcion de punto de inicio del lente en Y
      var newWidth = dp/rw;
      var newHeight = dp/rh;
      // console.log("Rw:"+rw+ " Nuevo Ancho: "+newWidth);
      // console.log("Rh:"+rh+ " Nuevo Largo: "+newHeight);

      //Ángulo de inclinación entre los puntos
      var degree = Math.atan2(dy, dx)

      ctx.save()
      ctx.translate(p1.x, p1.y)
      ctx.rotate(degree)

      //Posicion a ubicar los lentes -> p1.x es la nueva coordenada 0
      var px = -((dp/rpx)/4);
      var py = -(newHeight/2);
      // console.log("PX: "+px);
      // console.log("PY: "+py);
      ctx.drawImage(glasses,px,py,newWidth,newHeight);
      ctx.restore();
    }

    function uploadPhoto(input){
      width = 355, height = 267;

      if (input.files[0]) {
        glassOptions.style.display = 'none'
        glassTakePhoto.style.display = 'block'
        webcam.style.display = 'none';
        startbutton.style.display = 'none';
        list.style.display = 'none';
        tryGlasses.style.display = 'block';
        list2.style.display = 'block'
        list.style.display = 'none'


        var reader = new FileReader();
        var img = new Image()
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);

        reader.onload = function (e) {
          photo.setAttribute('src', e.target.result) ;
          img.src = e.target.result

          img.onload = function(){
            // console.log('original' + img.naturalWidth, img.naturalHeight);
            var r = width/img.naturalWidth
            var imgheight = img.naturalHeight*r
            var imgwidth = img.naturalWidth*r
            if (imgheight < height) {
              imgheight = height
            }
            // console.log('redim' + imgwidth, imgheight);
            // ctx.drawImage(img, 0, 0, width, height);
            ctx.drawImage(img, 0, 0, imgwidth, imgheight);
            width = imgwidth
            height = imgheight
            showMessage();
            drawEyes();
            document.getElementById('glasses-test').style.display = 'block';
          }
        }
        reader.readAsDataURL(input.files[0]);
      }else{// console.log('sin archivo');
      }
    }
  }
}
</script>

<style lang="scss">
  .dpi {
    height: 1in;
    left: -100%;
    position: absolute;
    top: -100%;
    width: 1in;
  }
</style>
