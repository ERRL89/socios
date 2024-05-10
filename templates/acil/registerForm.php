<!-- Formulario de Contrato -->
<?php
  if(isset($_POST['root'])){ $root=$_POST['root'];}
  include_once($root."config/config.php");
  include_once($root."config/dbConf.php");
?>

<!-- Formulario de Registro de Nuevo Usuario -->
<div class="mb-5">
  <h2 class="text-center">Formulario de Registro</h2>
  <h5 class="text-center textCustom fw-bold">SOCIOS ACIL</h5>
  <h6 class="text-center">* Por favor llene los campos solicitados *</h6>
  <form id="form">
    <!-- Formulario de Contrato -->
    <div class="container-sm container_form_custom">

      <span class="mb-5 fw-bold fst-italic fs-5 textCustom">Datos generales</span>

      <div class="mt-3 mb-3 "><!-- Nombre/Numero de Referido -->
       <div class="row mb-3">
          <div class="col-md-8"><!-- Nombre -->
            <label for="nombre" class="form-label label-custom">Nombre/Razón social:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" required>
            <div class="invalid-feedback">Introduce tu Nombre</div>
          </div>
          <div class="col-md-4"><!-- Numero de Referido -->
              <label for="referido" class="form-label label-custom">Número de Referido:</label>
              <input type="number" class="form-control sinBotonera" id="referido" name="referido">
          </div>
        </div>
      </div>

      <div class="mb-3 "><!-- Representante Legal/Nacionalidad/RFC -->
       <div class="row mb-3">
          <div class="col-md-6"><!-- Representante Legal -->
            <label for="representanteLegal" class="form-label label-custom">Representante Legal:</label>
            <input type="text" class="form-control" id="representanteLegal" name="representanteLegal">
          </div>
          <div class="col-md-6"><!-- Nacionalidad -->
            <label for="nacionalidad" class="form-label label-custom">Nacionalidad:</label>
            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" required>
            <div class="invalid-feedback">Introduce tu nacionalidad</div>
          </div>
        </div>
      </div>

      <span class="mb-5 fw-bold fst-italic fs-5 textCustom">Datos de contácto</span>

      <div class="mb-3 mt-3"><!-- Direccion: Calle - Numero - Codigo Postal -->
        <label for="direccion" class="form-label label-custom">Dirección:</label>
        <div class="row mb-3">
          <div class="col-md-6 mb-2">
            <input type="text" class="form-control form-input" placeholder="Calle" id="calle" name="calle"  required>
            <div class="invalid-feedback">Introduce tu calle</div>
          </div>
          <div class="col-md-3 mb-2">
            <input type="text" class="form-control form-input" placeholder="Número" id="numero" name="numero" required>
            <div class="invalid-feedback">Introduce tu numero</div>
          </div>
          <div class="col-md-3 mb-2">
            <input type="number" class="form-control form-input" placeholder="Codigo Postal" id="cp" name="cp" required>
            <div class="invalid-feedback">Introduce tu codigo postal</div>
          </div>
        </div>
      </div>

      <div class="mb-3"><!-- Estado - Municipio - Colonia -->
        <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <input type="text" class="form-control form-input" placeholder="Municipio" id="municipio" name="municipio" required disabled>
            <div class="invalid-feedback">Introduce tu municipio</div>
          </div>
          <div class="col-md-4 mb-2">
            <input type="text" class="form-control form-input" placeholder="Estado" id="estado" name="estado" required disabled>
            <div class="invalid-feedback">Introduce tu estado</div>
          </div>
          <div class="col-md-4 mb-2">
          <select class="form-select" id="colonia" aria-label="Default select example" required>
            <option selected disabled>Selecciona tu colonia:</option>
          </select>
            <div class="invalid-feedback">Introduce tu colonia</div>
          </div>
        </div>
      </div>

      <div class="mt-3"><!-- Telefono/Email -->
        <div class="row mb-3">
            <div class="col-md-6"><!-- Telefono -->
              <label for="telefono" class="form-label label-custom">Teléfono:</label>
              <input type="number" class="form-control sinBotonera" id="telefono" name="telefono" required>
              <div class="invalid-feedback">Introduce tu teléfono</div>
            </div>
            <div class="col-md-6"><!-- Email -->
              <label for="email" class="form-label label-custom">Email:</label>
              <input type="email" class="form-control" id="email" name="email" required>
              <div class="invalid-feedback">Introduce tu email</div>
            </div>
        </div>
      </div>

      <span class="mb-5 fw-bold fst-italic fs-5 textCustom">Datos Bancarios</span>

      <div class="mb-3 mt-3"><!-- Cuenta Clabe/RFC -->
       <div class="row mb-3">
          <div class="col-md-6"><!-- Cuenta clabe -->
            <label for="cuentaClabe" class="form-label label-custom">Cuenta Clabe:</label>
            <input type="number" class="form-control sinBotonera" id="cuentaClabe" name="cuentaClabe" required>
          </div>
          <div class="col-md-6"><!-- RFC -->
            <label for="rfc" class="form-label label-custom">RFC:</label>
            <input type="text" class="form-control" id="rfc" name="rfc" required>
            <div class="invalid-feedback">Introduce tu RFC</div>
          </div>
        </div>
      </div>


     <!-- Boton de Contratar launchUploadFiles() -->
      <div class="container-fluid d-flex justify-content-center align-items-center ctBtnCustom">
          <?php
            $btn="
                    <center><button type='button' id='btnContinuar' class='btn btn-primary btn-custom' onClick='launchUploadFiles()' disabled >CONTINUAR</button></center> 
                 ";
            echo $btn;
          ?>
      </div>

      <!-- Captcha -->
      <div id="captchaCustom" class="container captcha-custom">
          <div class="g-recaptcha" data-sitekey="6LdCaLEpAAAAANnZxetHXNTkzF0WKYUqUZb--VAv" data-callback="onCaptchaSuccess"></div>
      </div>

      <!-- Boton Fake -->
      <center><button type='button' id='btnContinuarFake' class='btn btn-primary btn-custom-fake' disabled >CONTINUAR</button></center> 

    </div>
  </form>
</div>

<!-- MODAL-->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="progress">
                    <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
                <center><h2 id="progress-text">Procesando...</h2></center>
            </div>
        </div>
    </div>
</div>

<!-- Envio a Process para guardar usuario -->
<script>
    function launchUploadFiles(){
            var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            modal.show();
            var progressBar = $('#progress-bar');
            var progressText = $('#progress-text');
            
            $.ajax({
                url: 'registerProcess.php',
                type: 'POST',
                data: 
                {
                    nombre: $('#nombre').val(),
                    calle: $('#calle').val(),
                    numero: $('#numero').val(),
                    colonia: $('#colonia').val(),
                    email: $('#email').val(),
                    phone: $('#telefono').val()
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(event) {
                        if (event.lengthComputable) {
                            var percentComplete = (event.loaded / event.total) * 100;
                            progressBar.css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);
                            progressText.text('Procesando... ');
                        }
                    }, false);
                    return xhr;
                },
                success: function(result) {
                    $('#principal').html(result);
                    modal.hide();
                }
            });
    }
</script>


<!-- Control de botones y captcha -->
<script>
  $(document).ready(function() {
    $('#btnContinuar').hide();
    let fechaActual = new Date()
    let año = fechaActual.getFullYear()
    let mes = fechaActual.getMonth() + 1
    let dia = fechaActual.getDate()
    let fechaFormateada = (dia < 10 ? '0' : '') + dia + '-' + (mes < 10 ? '0' : '') + mes + '-' + año
  })
  //Muestra botones cuando se resuelve Captcha
  function mostrarBotonContinuar() {
    $('#captchaCustom').hide();
    $('#btnContinuarFake').hide();
    $('#btnContinuar').show();
    $('#btnContinuar').removeAttr('disabled');
  }
  //Oculta botones si no se resuelve Captcha
  function ocultarBotonContinuar() {
    $('#btnContinuar').prop('disabled', true);
  }
  //Acciones cuando se resuelve Captcha
  function onCaptchaSuccess(response) {
    if (response) {
      mostrarBotonContinuar();
    } else {
      ocultarBotonContinuar();
    }
  }
</script>





