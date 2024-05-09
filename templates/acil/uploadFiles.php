<!-- Define llamado a ruta de proceso de carga de documentación -->
<?php
  if(isset($_POST['root']))        { $root=$_POST['root'];}
  if(isset($_POST['idUsuario'])) { $idUsuario=$_POST['idUsuario'];}
  include_once($root."config/config.php");
  include_once($root."config/dbConf.php");

#DEFINICION DE PARAMETROS A ENVIAR EN FUNCIÓN
  $inputForm = "form";
  $routeProcess = "/{$folderBase}uploadFilesProcess.php";
  $generalCanvas = "principal";
  $table = "";
  $elementsToHide = ""; //Se deben separar con comas los elementos debido a que se ingresan en un array
  $optionalFunction = "function() { launchForm(1,{$idUsuario}); }";

#CONSTRUCCIÓN DE FUNCIÓN
  $functionParameters = " 
    getProcessForm(
        '{$inputForm}',  
        '{$routeProcess}', 
        '{$generalCanvas}', 
        '{$table}', 
        '{$elementsToHide}', 
        {$optionalFunction}
     );
                        ";

  //Variables que reciban si ya fue cargado el archivo correspondiente para control de boton Validacion
  $constancia=0;
  $domicilio=0;
  $identificacion=0;
  $pago=0;
  $contrato=0;

  //Funcion que valida ruta de documentos, asigna enlace a documentos 7 retira leyendas de advertencia 
  function validateFile($name, $numero){
        global $idUsuario, $root, $folderBase, $domicilio, $identificacion, $pago, $contrato, $constancia;
        $archivo = $name.$idUsuario.".pdf";
            $rutaArchivo = $root."docs/users/".$idUsuario."/".$archivo;
            if (file_exists($rutaArchivo)) {
                if($numero==0){
                    echo "<a href='/".$folderBase."docs/users/".$idUsuario."/".$archivo."'target='_blank'>[".$name."".$idUsuario.".pdf]</a>";

                    if($name=="comprobante_domicilio_"){ $domicilio=1; }
                    if($name=="identificacion_oficial_"){ $identificacion=1; }
                    if($name=="comprobante_pago_"){ $pago=1; }
                    if($name=="contrato_"){ $contrato=1; }
                    if($name=="constancia_situacion_fiscal_"){ $constancia=1; }
                }
                //Elimina leyenda de ADVERTENCIA Limite de Carga cuando ya se detecto la carga del archivo
                else if($numero==1){ echo ""; }
                
            } else {
                if($numero==0){
                    echo "No se ha cargado el archivo.";
                } 
                if($numero==1){
                    //Agrega leyenda de ADVERTENCIA Limite de Carga cuando ya se detecto la carga del archivo
                    echo "¡ADVERTENCIA! Límite por archivo: 4MB - Archivos más pesados no se subirán.";
                } 
            } 
    }
?>

<!-- Formulario para carga de Documentos -->
<div class="mb-5" id=uploadForm><br>
  <h2 class="text-center" id="texto">Sube tus Documentos</h2>
  <form id="form" class="mb-5" action="" method="post" enctype="multipart/form-data" onchange="checkFileSize(this)" novalidate>
    <div class="container-sm container_form_custom">

      <!-- ------------------------ ID DE USUARIO ---------------------------- -->
      <input type="hidden" name="idUsuario" id="nc" class="form-control" value="<?php echo $idUsuario;?>"/>

      <!-- ------------------------CARGA DE COMPROBANTE DE DOMICILIO---------------------------- -->
      <label for="domicilio" class="form-label label-custom">Comprobante de Domicilio</label>
      <label id="comprobante_label_edit" class='form-label' style='color:#e25b19'>
        <?php validateFile("comprobante_domicilio_",0);?>
      </label>
      <input type="file" name="domicilio" id="domicilio" class="form-control" accept=".pdf"/>
      <div id='advertencia1' class='form-text' style='color: red;'>
        <?php validateFile("comprobante_domicilio_",1);?>
      </div><br>
      <!-- ------------------------------------------------------------------------------------- -->


      <!-- --------------------------CARGA DE IDENTIFICACION OFICIAL---------------------------- -->
      <label for="identificacion" class="form-label label-custom">Identificación Oficial</label>
      <label id="ine_label_edit" class='form-label' style='color:#e25b19'>
        <?php validateFile("identificacion_oficial_",0);?>
      </label>
      <input type="file" name="identificacion" id="identificacion" class="form-control" accept=".pdf"/>
      <div id='advertencia2' class='form-text' style='color: red;'>
        <?php validateFile("identificacion_oficial_",1);?>
      </div><br>
      <!-- ------------------------------------------------------------------------------------- -->

      <!-- --------------------------CARGA DE COMPROBANTE DE PAGO---------------------------- -->
      <label for="pago" class="form-label label-custom">Comprobante de Pago</label>
      <label id="pago_label_edit" class='form-label' style='color:#e25b19'>
        <?php validateFile("comprobante_pago_",0);?>
      </label>
      <input type="file" name="pago" id="pago" class="form-control" accept=".pdf"/>
      <div id='advertencia3' class='form-text' style='color: red;'>
        <?php validateFile("comprobante_pago_",1);?>
      </div><br>
      <!-- ------------------------------------------------------------------------------------- -->

      <!-- -------------------------------CARGA DE CONTRATO------------------------------------- -->
      <label for="contrato" class="form-label label-custom">Contrato</label>
      <label id="contrato_label_edit" class='form-label' style='color:#e25b19'>
        <?php validateFile("contrato_",0);?>
      </label>
      <input type="file" name="contrato" id="contrato" class="form-control" accept=".pdf"/>
      <div id='advertencia4' class='form-text' style='color: red;'>
        <?php validateFile("contrato_",1);?>
      </div><br>
      <!-- ------------------------------------------------------------------------------------- -->


      <div><!-- --------------------------¿REQUIERE FACTURA?---------------------------- -->
            <label class="form-label">¿Requiere factura?</label>
            <div class="form-check">
                <input class="check-custom" type="radio" id="okFactura" value="1">
                <label class="form-check-label">
                    Si, requiero factura
                </label>
            </div>
            <div class="form-check" id="formNoFactura">
                <input class="check-custom" type="radio" id="noFactura" value="0" checked>
                <label class="form-check-label">
                    No, no requiero factura
                </label>
            </div>
      </div><br>
      <!-- ------------------------------------------------------------------------------------- -->


      <!-- --------------------------CARGA DE CONSTANCIA DE SITUACION FISCAL---------------------------- -->
      <div id="constancia"><label for="file" class="form-label label-custom">Constancia de Situación Fiscal</label>
      <label id="constancia_label_edit" class='form-label' style='color:#e25b19'>
        <?php validateFile("constancia_situacion_fiscal_",0);?>
      </label>
      <input type="file" name="constanciaFiscal" id="constanciaFiscal" class="form-control" accept=".pdf"/>
      <div id='advertencia5' class='form-text' style='color: red;'>
        <?php validateFile("constancia_situacion_fiscal_",1);?>
      </div></div><br><br>
      <!-- ------------------------------------------------------------------------------------- -->
      <div class="container-fluid d-flex justify-content-center align-items-center flex-wrap gap-2 mb-3">
      <?php
            //Se asigna boton para subir archivos se actualiza de acuerdo a cada carga
            $btn="
                    <center><input id='btnEnviar' class='btn btn-primary btn-custom text-center mr-3 mt-2' type='button' value='Subir Archivo' 
                    onclick=\"{$functionParameters}\" disabled/></center>
            ";echo $btn;

            //Se asigna boton de enviar a validacion, se dibuja de acuerdo al siguiente IF
            if($domicilio==1 && $identificacion==1 && $pago==1 && $contrato==1){
                $btn2="
                    <center><input id='btnValidacion' class='btn btn-primary btn-custom text-center mt-2' type='button'  onclick='sendValidation()' value='Enviar a validación'/></center>
                ";echo $btn2;
            }
      ?>
      </div>
    
    </div>

  </form>
</div>

<?php
    #CONSTRUCCIÓN DE BARRA DE PROGRESO
    $messageProgress = "Subiendo archivo";
    include_once($root."templates/acil/progressBar.php");    
?>

<!-- Función de Boton Enviar a Validacion -->
<script>
  function sendValidation(){
    var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();
    let btnValidation=1
    let idUsuario='<?php echo $idUsuario;?>'
    let root='<?php echo $root;?>'
      $.ajax({
            url: './templates/acilQuote/uploadFilesValidation.php',
            type: 'POST',
            data: 
                {
                  idUsuario:idUsuario,
                  btnValidation:btnValidation,
                  root:root
                },
            success: function(result)
                {
                  modal.hide();
                  $('#principal').html(result);
                }
            });       
  }
</script>

<!-- Calcula el tamaño de los archivos a cargar -->
<script>
    function checkFileSize(form) {
        var inputs = form.querySelectorAll('input[type="file"]');
        var maxSize = 30*1024*1024; // Tamaño máximo permitido en bytes
        for (var i = 0; i < inputs.length; i++) {
            if(inputs[i].value != ''){
                var fileSize = inputs[i].files[0].size; // Tamaño del archivo en bytes
                if (fileSize > maxSize) {
                    alert("El archivo es demasiado grande. Por favor, sube un archivo más pequeño.");
                    inputs[i].value = '';
                }
            }
        }
    }
</script>

<!-- Control de selector Requiere/No Requiere Factura -->
<script>
    $(document).ready(function(){
        $("#constancia").hide()
        <?php
          if($constancia==1){
            echo "
                  $('#okFactura').prop('checked', true)
                  $('#noFactura').prop('checked', false)
                  $('#formNoFactura').hide()
                  $('#constancia').show()
                ";
          }
        ?>
        $("#okFactura").change(function() {
            if(this.checked) {//Si se selecciona "Si requiero factura"
                $("#noFactura").prop("checked", false)//Retira seleccion a No requiero factura
                $("#constancia").show()
                $("#btnValidacion").hide()
                
               
            } else {//Si se intenta quitar seleccion a opcion seleccionada no lo permite
                if(!$("#noFactura").prop("checked")) {
                    $(this).prop("checked", true);
                }
            }
        })

        $("#noFactura").change(function() {
            if(this.checked) {
                $("#okFactura").prop("checked", false)
                $("#constancia").hide()
                $("#btnValidacion").show()
              
            } else {
                if(!$("#okFactura").prop("checked")) {
                    $(this).prop("checked", true);
                }
            }
        })

        $('input[type="file"]').change(function() {
            if (this.files && this.files.length > 0) {
                $('#btnEnviar').removeAttr('disabled');
            } else {
                console.log("No se ha seleccionado ningún archivo.");
            }
        });

    });
</script>
