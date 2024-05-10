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

      <div class="mt-3 mb-3 "><!-- Nombre/Apellido/Numero de Referido -->
       <div class="row mb-3">
          <div class="col-md-5"><!-- Nombre -->
            <label for="nombre" class="form-label label-custom">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" required>
            <div class="invalid-feedback">Introduce tu Nombre</div>
          </div>
          <div class="col-md-5"><!-- Apellido -->
            <label for="apellido" class="form-label label-custom">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+">
            <div class="invalid-feedback">Introduce tu Apellido</div>
          </div>
          <div class="col-md-2"><!-- Numero de Referido -->
              <label for="referido" class="form-label label-custom"># Referido:</label>
              <input type="number" class="form-control sinBotonera" id="referido" name="referido">
          </div>
        </div>
      </div>

      <div class="mb-3 "><!-- Representante Legal/Nacionalidad/RFC -->
       <div class="row mb-3">
          <div class="col-md-6"><!-- RFC -->
            <label for="rfc" class="form-label label-custom">RFC:</label>
            <input type="text" class="form-control" id="rfc" name="rfc" required>
            <div class="invalid-feedback">Introduce tu RFC</div>
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

      <span class="mt-3 mb-5 fw-bold fst-italic fs-5 textCustom">Datos Bancarios</span>

      <div class="mb-3 mt-3"><!-- Cuenta Clabe/RFC -->
       <div class="row mb-3">
          <div class="col-md-6"><!-- Cuenta clabe -->
            <label for="clabe" class="form-label label-custom">Clabe interbancaria:</label>
            <input type="number" class="form-control sinBotonera" id="clabe" name="clabe" required>
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

<!-- Funcionalidad de codigo postal mediante api -->
<script>
  const elemento = document.getElementById('cp');
  let selectColonia = document.getElementById('colonia');
  
  function miFuncion() {
      $.ajax({
						url: 'resources/api_cp/cp.php',
						type: 'POST',
            dataType: 'json',
            data:{
              codigoPostal:$('#cp').val()
            },
						success: function(result)
						{
              $('#colonia').empty();

              console.log(result); 
              $('#estado').val(result.codigo_postal.estado)
              $('#municipio').val(result.codigo_postal.municipio)

              colonia=result.codigo_postal.colonias
              console.log(colonia)

              for(let i=0; i<=colonia.length-1; i++){
                let nuevaOpcion = document.createElement('option');
                nuevaOpcion.value = result.codigo_postal.colonias[i];
                nuevaOpcion.textContent = result.codigo_postal.colonias[i]; 
                selectColonia.appendChild(nuevaOpcion);
              }
						}
					});
  }

  elemento.addEventListener('change', miFuncion);
</script>

<!-- Envio a Process para guardar usuario -->
<script>
  let form = document.getElementById("form");
    function launchUploadFiles(){
            
            if (form.checkValidity())
            {
              var progressBar = $('#progress-bar');
              var progressText = $('#progress-text');
              $.ajax({
                url: 'registerProcess.php',
                type: 'POST',
                data: 
                {
                    nombre: $('#nombre').val(),
                    apellido: $('#apellido').val(),
                    referido: $('#referido').val(),
                    nacionalidad: $('#nacionalidad').val(),
                    calle: $('#calle').val(),
                    numero: $('#numero').val(),
                    cp: $('#cp').val(),
                    municipio: $('#municipio').val(),
                    estado: $('#estado').val(),
                    colonia: $('#colonia').val(),
                    telefono: $('#telefono').val(),
                    email: $('#email').val(),
                    clabe: $('#clabe').val(),
                    rfc: $('#rfc').val()
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
                }
              });
            }
            else 
            {
              form.classList.add('was-validated')
            }    
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





