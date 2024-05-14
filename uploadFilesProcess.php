<?php
    include_once('config/config.php');
    include_once('config/dbConf.php');
    if(isset($_POST['idUsuario'])){ $idUsuario=$_POST['idUsuario']; }
    
//Recibimos COMPROBANTE DE DOMICILIO cargado desde formulario, se guarda en carpeta correspondiente y se le asigna nombre
    if(isset($_FILES['domicilio']) && !empty($_FILES['domicilio']['name'])) {
        $comprobanteDomicilio = $_FILES['domicilio'];

        $rutaDestino = $root."docs/partners/".$idUsuario."/".$comprobanteDomicilio['name'];

            if(move_uploaded_file($comprobanteDomicilio['tmp_name'], $rutaDestino)) {
                $nombreArchivo = "comprobante_domicilio_".$idUsuario.".pdf";
                $rutaNuevoNombre = $root."docs/partners/".$idUsuario."/".$nombreArchivo; 

                if (rename($rutaDestino, $rutaNuevoNombre)) {
                    $archivoCargado=1;
                }else{
                    $archivoCargado=0;
                }
            }else{
                $archivoCargado=0;
            } 
    }

//Recibimos IDENTIFICACION OFICIAL cargada desde formulario, se guarda en carpeta correspondiente y se le asigna nombre
    if(isset($_FILES['identificacion']) && !empty($_FILES['identificacion']['name'])) {    
        $identificacionOficial = $_FILES['identificacion'];
        $rutaDestino = $root."docs/partners/".$idUsuario."/".$identificacionOficial['name'];

        if(move_uploaded_file($identificacionOficial['tmp_name'], $rutaDestino)) {
            $nombreArchivo = "identificacion_oficial_".$idUsuario.".pdf";
            $rutaNuevoNombre = $root."docs/partners/".$idUsuario."/".$nombreArchivo; 
            if (rename($rutaDestino, $rutaNuevoNombre)) {
                $archivoCargado=1;
            }else{
                $archivoCargado=0;
            }
        }else{
            $archivoCargado=0;
        } 
    }

//Recibimos COMPROBANTE DE PAGO cargado desde formulario, se guarda en carpeta correspondiente y se le asigna nombre
    if(isset($_FILES['pago']) && !empty($_FILES['pago']['name'])) {    
        $comprobantePago = $_FILES['pago'];

        $rutaDestino = $root."docs/partners/".$idUsuario."/".$comprobantePago['name'];

        if(move_uploaded_file($comprobantePago['tmp_name'], $rutaDestino)) {
            $nombreArchivo = "comprobante_pago_".$idUsuario.".pdf";
            $rutaNuevoNombre = $root."docs/partners/".$idUsuario."/".$nombreArchivo; 
            if (rename($rutaDestino, $rutaNuevoNombre)) {
                $archivoCargado=1;
            }else{
                $archivoCargado=0;
            }
        }else{
            $archivoCargado=0;
        } 
    }

//Recibimos CONTRATO cargado desde formulario, se guarda en carpeta correspondiente y se le asigna nombre
    if(isset($_FILES['contrato']) && !empty($_FILES['contrato']['name'])) {
        $contrato = $_FILES['contrato'];

        $rutaDestino = $root."docs/partners/".$idUsuario."/".$contrato['name'];

        if(move_uploaded_file($contrato['tmp_name'], $rutaDestino)) {
            $nombreArchivo = "contrato_".$idUsuario.".pdf";
            $rutaNuevoNombre = $root."docs/partners/".$idUsuario."/".$nombreArchivo; 
            if (rename($rutaDestino, $rutaNuevoNombre)) {
                $archivoCargado=1;
            }else{
                $archivoCargado=0;
            }
        }else{
            $archivoCargado=0;
        } 
    }

//Recibimos CONSTANCIA DE SITUACION FISCAL cargada desde formulario, se guarda en carpeta correspondiente y se le asigna nombre
    if(isset($_FILES['constanciaFiscal']) && !empty($_FILES['constanciaFiscal']['name'])) {
        $constanciaFiscal = $_FILES['constanciaFiscal'];

        $rutaDestino = $root."docs/partners/".$idUsuario."/".$constanciaFiscal['name'];

        if(move_uploaded_file($constanciaFiscal['tmp_name'], $rutaDestino)) {
            $nombreArchivo = "constancia_situacion_fiscal_".$idUsuario.".pdf";
            $rutaNuevoNombre = $root."docs/partners/".$idUsuario."/".$nombreArchivo; 
            if (rename($rutaDestino, $rutaNuevoNombre)) {
                $archivoCargado=1;
            }else{
                $archivoCargado=0;
            }
        }else{
            $archivoCargado=0;
        } 
    }
//-----------------------------------------------
   
    if($archivoCargado==1){
        $messageSuccess="<h3>Archivo cargado correctamente</h3>";
        include $root."templates/acil/successPage.php";
        echo "<br>";
    }

    else if($archivoCargado==0){
        $messageError="<h3>Error al cargar el archivo</h3>";
        include $root."templates/acil/errorPage.php";
        echo "<br>";
    }

?>