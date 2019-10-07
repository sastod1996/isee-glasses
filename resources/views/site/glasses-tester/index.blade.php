<div class="uk-container uk-margin">
  <div uk-grid>
    <div class="uk-width-1-2">
      <div class="uk-margin">
        <video id="video"></video>
      </div>
      <div uk-grid>
        <div class="uk-width-1-2">
          <button id="startbutton" class="uk-button uk-button-primary uk-light">Tomar foto</button>
        </div>
        <div class="uk-width-1-2 test-upload" uk-form-custom>
          <input id="loadPhoto" type="file" accept="image/jpeg, image/png">
          <a class="uk-button uk-button-primary uk-light" type="button" tabindex="-1" >
            <span uk-icon="icon: upload"></span>
            <span>Subir foto</span>
          </a>
        </div>
      </div>
    </div>
    <div class="uk-width-1-2">
      <div class="uk-margin">
        <canvas id="canvas" ></canvas>
        <img hidden src="http://placekitten.com/g/320/261" id="photo" alt="photo">
      </div>
      <div id="glasses-test" style="display:none;">
      {{-- <div id="glasses-test"> --}}
        <button id="tryGlasses" class="uk-button uk-button-secondary">Probar lentes</button>
        <img hidden src="/images/DSC_0042.png" id="glasses" alt="glasses">
      </div>
    </div>
  </div>
</div>

@push('head')

<script>

    window.onload = function() {
      var streaming    = false
      var video        = document.querySelector('#video')
      var width = 320, height = 0
      // var width = 500, height = 0
      var canvas       = document.querySelector('#canvas')
      var ctx = canvas.getContext("2d")
      var photo        = document.querySelector('#photo')
      var startbutton  = document.querySelector('#startbutton')
      var tryGlasses   = document.querySelector('#tryGlasses')
      var loadPhoto   = document.querySelector('#loadPhoto')

      var x1 = 120, y1 = 80 //Posición inicial del punto 1
      var x2 = 190, y2 = 80 //Posición inicial del punto 2
      var arrastrar = false
      var id = 0 //1: cerca al punto 1  - 2: cerca al punto 2
      var tolerance = 5 //distancia de proximidad ('que tan cerca de ...')

      navigator.getMedia = ( navigator.getUserMedia ||
                             navigator.webkitGetUserMedia ||
                             navigator.mozGetUserMedia ||
                             navigator.msGetUserMedia);

      navigator.getMedia(
        {video: true, audio: false},
        function(stream) {
          if (navigator.mozGetUserMedia) {
            video.mozSrcObject = stream;
          }else{
            var vendorURL = window.URL || window.webkitURL;
            video.src = vendorURL.createObjectURL(stream);
          }
          video.play();},
        function(err) {
          // console.log("An error occured! " + err);
        }
      );

      // Redifiniendo tamaño del video
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

      startbutton.addEventListener(
        'click',
        function(ev){
          takePhoto();
          ev.preventDefault();
        },
        false
      );

      function takePhoto() {
        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(video, 0, 0, width, height);
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

        // Calculamos distancia de los puntos
        var dx = p2.x - p1.x // p1.x - p2.x;
        var dy = p2.y - p1.y // p1.y - p2.y;
        var dp = Math.abs(Math.sqrt(dx*dx+dy*dy));
        var glasses = document.querySelector('#glasses');
        // console.log("Punto 1: x:" + p1.x + " y: "+p1.y);

        // Distancia entre los ojos de los lentes
        // var g1 = {x:175.748031496, y:187.842519685} // {x:4.65, y:4.97} cm
        // var g2 = {x:402.141732283, y:187.842519685} //{x:10.64, y:4.97} cm
        // var dx1 = g1.x - g2.x;
        // var dy1 = g1.y - g2.y;
        // var dg = Math.abs(Math.sqrt(dx1*dx1+dy1*dy1));
        // console.log('distance:' + distance1) //226.393700787
        var dg = 705.393700787 //distancia mas chica, lentes mas grandes
        var r = dp/dg;
        // console.log("Proporcion: "+r);
        var newWidth = r*1772;
        var newHeight = r*1181;
        // console.log("Nuevo Ancho: "+newWidth);
        // console.log("Nuevo Largo: "+newHeight);
        var px = p1.x - r*550
        var py = p1.y - r*550
        // console.log("PX: "+px);
        // console.log("PY: "+py);

        var degree = Math.atan2(dy, dx)
        // console.log("Rotacion: "+180*degree/Math.PI)
        // console.log(45*Math.PI/180);
        ctx.save()
        ctx.translate(p1.x, p1.y)
        ctx.rotate(degree)
        // px = px - r*100
        // py = py - r*550
        // console.log("PX: "+px);
        // console.log("PY: "+py);
        ctx.drawImage(glasses, -r*550, -r*550, newWidth, newHeight);
        ctx.restore();
      }

      loadPhoto.addEventListener(
        'change',
        function(ev){
          uploadPhoto(this);
          ev.preventDefault();
        },
        false
      );

      function uploadPhoto(input){
        if (input.files[0]) {
          var reader = new FileReader();
          var img = new Image()

          reader.onload = function (e) {
            photo.setAttribute('src', e.target.result) ;
            img.src = e.target.result
            // ctx.drawImage(img, 0, 0);
            // photo.setAttribute('src', e.target.result) ;
            img.onload = function(){
              ctx.drawImage(img, 0, 0, width, height );
              drawEyes();
              document.getElementById('glasses-test').style.display = 'block';
            }
          }
          reader.readAsDataURL(input.files[0]);
        }else{// console.log('sin archivo');
        }
      }
    }//)();
</script>
@endpush
