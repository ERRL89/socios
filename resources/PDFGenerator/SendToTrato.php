<?php
    /////////////////// AJUSTES INICIALES ///////////////////
    header("Cache-Control: no-cache, must-revalidate");
    setlocale(LC_TIME,"spanish");

    /////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////
    use setasign\Fpdi;
    require_once($root.'resources/tcpdf/tcpdf.php');
    require_once($root.'resources/fpdi/autoload.php');
    /////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////

    $db = conexionPdo();

    /*
    $numeroCotizacion= $_GET["numeroCotizacion"];
    $nombre= $_GET["nombre"];
    $calle= $_GET["calle"];
    $numero= $_GET["numero"];
    $colonia= $_GET["colonia"];
    $direccion=$calle." ".$numero." ".$colonia;
    $telefono= $_GET["telefono"];
    $email= $_GET["email"];
    $kitType= $_GET["kitType"];
    $kitMensualidad= $_GET["kitMensualidad"];
    $acuerdoPago= $_GET["acuerdoPago"];
    $modalidad= $_GET["modalidad"];
    $frecuenciaPago= $_GET["frecuenciaPago"];
    $fechaInicio= $_GET["fechaInicio"];
    $metodoPago= $_GET["metodoPago"];
    $persona= $_GET["persona"];
    $representanteLegal= $_GET["representanteLegal"];
    $escritura= $_GET["escritura"];
    $idUsuario= $_GET["idUsuario"];
    $contacto1= $_GET["contacto1"];
    $telefono1= $_GET["telefono1"];
    $contacto2= $_GET["contacto2"];
    $telefono2= $_GET["telefono2"];
    $titularTarjeta= $_GET["titularTarjeta"];
    $numeroTarjeta= $_GET["numeroTarjeta"];
    $expiracion= $_GET["expiracion"];
    $codigoSeguridad= $_GET["codigoSeguridad"];

    //--------------------------------------------------------------------------
    /*

    $trato = $_POST['trato'];
    $tipo_cliente = $_POST['tipo_cliente'];
    $cotizacion = $_POST['cotizacion'];
    $email = $_POST['email'];
    $nombre_cliente = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $modalidad = $_POST['modalidad'];
    $mensualidad = $_POST['mensualidad'];
    $forma_pago = $_POST['forma_pago'];
    $acuerdo_pago = $_POST['acuerdo_pago'];
    $fechaInicio = $_POST['inicio_contrato'];
    $forma_cobro = $_POST['forma_cobro'];    

    if($tipo_cliente == '2')
    {
        $representante = $_POST['representante'];
        $escritura = $_POST['escritura'];
    }
    else
    {
        $representante = "";
    }
    
    if($_POST['contacto1'] != "")
    {
        $contacto1 = $_POST['contacto1'];
    }
    else
    {
        $contacto1 = NULL;
    }
    
    if($_POST['telefono1'] != "")
    {
        $telefono1 = $_POST['telefono1'];
    }
    else
    {
        $telefono1 = NULL;
    }
    
    if($_POST['contacto2'] != "")
    {
        $contacto2 = $_POST['contacto2'];
    }
    else
    {
        $contacto2 = NULL;
    }
    
    if($_POST['telefono2'] != "")
    {
        $telefono2 = $_POST['telefono2'];
    }
    else
    {
        $telefono2 = NULL;
    }

    //Calculo de cantidad total y residual////
    $valor_total = 36 * $mensualidad;
    $residual = 0.25 * $valor_total;
    /////////////////////////////////////////
    
    //Calculo fecha final contrato////
    
    /////////////////////////////////// 

    /*
    if($forma_cobro == 4)
    {
        $query = "SELECT * FROM suscripciones_formulario WHERE numero_cliente = '$numero_cliente'";
        $consulta_numcte = mysqli_query($con, $query) or die('Consulta de cerrador fallida -- Error: ' . mysqli_errno($con));
        $contador_resultados=mysqli_num_rows($consulta_numcte); //pregunta si la busqueda tiene exito
        if ($contador_resultados==0)
        {
            require(dirname(__FILE__) . '/openpay/Openpay.php');
            // INSTANCIAMOS CON ID Y LLAVE PRIVADA (MODO SANDBOX)
            //$openpay = Openpay::getInstance('meqbc1rusn21h1gbnwjx', 'sk_8b9b782c303f493a87183dd3dc8bc5ba', 'MX');
            //Openpay::setProductionMode(false);
            
            // INSTANCIAMOS CON ID Y LLAVE PRIVADA (MODO PRODUCCIÓN)
            $openpay = Openpay::getInstance('mmuha4s6gfqtu1qggnfb', 'sk_d553e460ed5547028ca4dd908a95be3f', 'MX');
            Openpay::setProductionMode(true);
            
            // CREAMOS AL CLIENTE EN LA API
            $customerData = array(
             'external_id' => "$numero_cliente",
             'name' => "$nombre_cliente",
             'last_name' => "",
             'email' => "$email"
            );
    
            $customer = $openpay->customers->add($customerData);
            $id_api = $customer->id;
            
            $sql = "INSERT INTO suscripciones_formulario(prospecto,numero_cliente,email,telefono,nombre,id) VALUES('$prospecto','$numero_cliente','$email','$telefono','$nombre_cliente','$id_api')" or die('No se pudo insertar: ' . mysqli_errno($con));
            $result = mysqli_query($con,$sql);
        }
        
        //////////////////////////////// SE ENVIA CORREO ////////////////////////////////
        include 'email_info_inscripcion.php';
        //////////////////////////////// SE ENVIA CORREO ////////////////////////////////
    }
    */
    $kitMensualidad=1;//edson
    $valor_total = 36 * $kitMensualidad;
    $residual = 0.25 * $valor_total;

    $fechaInicio="2024-04-08";//edson
    $fin_contrato = strtotime('+3 years -1 day', strtotime($fechaInicio));
    $fin_contrato = date('Y-m-d', $fin_contrato);
    ///////////////// SE INSTANCIA LA CLASE DEL PDF /////////////////
    //////// SE PUEDE AÑADIR ENCABEZADO Y PIE DE PAGINA AQUÍ ////////
    class Pdf extends Fpdi\Tcpdf\Fpdi
    {
        /**
         * "Remembers" the template id of the imported page
         */
        protected $tplId;

        /**
         * Draw an imported PDF logo on every page
         */
        function Header()
        {
            // emtpy method body
        }

        function Footer()
        {
            // emtpy method body
        }
    }
    ///////////////// SE INSTANCIA LA CLASE DEL PDF /////////////////
    //////// SE PUEDE AÑADIR ENCABEZADO Y PIE DE PAGINA AQUÍ ////////

    ///////////////// SE CREA OBJETO PDF /////////////////
    $pdf = new pdf();
    ///////////////// SE CREA OBJETO PDF /////////////////

    ////////////// SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS //////////////
    $pagecount = $pdf->setSourceFile($root."docs/templatesFpdi/leasingContract.pdf");
    ////////////// SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS //////////////
    
    ////////////// SE CREA CICLO PARA IMPORTAR TODAS LAS HOJAS DEL CONTRATO //////////////
    for($i = 1; $i <=5; $i++)
    {
        $tpl = $pdf->importPage($i);
        $size = $pdf->getTemplateSize($tpl);
        $pdf->AddPage('P', 'LETTER');
        $pdf->useTemplate($tpl);
    }

    
    // (QUITAR CUANDO SE TERMINE DE CONFIGURAR)
    /*
    $tpl = $pdf->importPage(5);
    $size = $pdf->getTemplateSize($tpl);
    $pdf->AddPage('P', 'LETTER');
    $pdf->useTemplate($tpl);
    */
    ////////////// SE CREA CICLO PARA IMPORTAR TODAS LAS HOJAS DEL CONTRATO //////////////

    ///////////////// REALIZAMOS CONSULTA A LA BD ///////////////////
    /*COMENTARIOS

    $queryString = "SELECT 
    prospecto,
    numero_cliente,
    clientes.perfilador,
    perfiladores.nombre as nombre_perfilador,
    perfiladores_users.email as email_perfilador,
    clientes.cerrador,
    cerradores.nombre as nombre_cerrador,
    cerradores_users.email as email_cerrador,
    correo,
    razon_social
    FROM tratos_prospecto
    JOIN clientes ON tratos_prospecto.prospecto = clientes.id_cliente
    JOIN colaboradores as perfiladores ON perfiladores.id_colaborador = clientes.perfilador
    JOIN usuarios as perfiladores_users ON perfiladores_users.id_usuario = perfiladores.usuario
    JOIN colaboradores as cerradores ON cerradores.id_colaborador = clientes.cerrador
    JOIN usuarios as cerradores_users ON cerradores_users.id_usuario = cerradores.usuario
    WHERE id_trato = ?";
    $query = $db->prepare($queryString);
    $query -> execute(array($trato));
    $data = $query->fetch(PDO::FETCH_ASSOC);

    $prospecto = $data['prospecto'];
    $numero_cliente = $data['numero_cliente'];
    $cerrador = $data['cerrador'];
    $email_cliente = $data['correo'];
    $nombre_perfilador = $data['nombre_perfilador'];
    $correo_perfilador = $data['email_perfilador'];
    $nombre_cerrador = $data['nombre_cerrador'];
    $correo_cerrador = $data['email_cerrador'];
    $razon_social = $data['razon_social'];

    $queryString = "SELECT numero FROM folios WHERE id_folio = 3";
    $query = $db->prepare($queryString);
    $query -> execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    $folio_actual = $data['numero'];
    $nuevo_folio = $folio_actual + 1;

    $queryString = "UPDATE folios SET numero = $nuevo_folio WHERE id_folio = 3";
    $query = $db->prepare($queryString);
    $query -> execute();

    $queryString = "UPDATE tratos_prospecto SET numero_contrato = ?, clase_contrato = 2 WHERE id_trato = ?";
    $query = $db->prepare($queryString);
    $query -> execute(array($nuevo_folio,$trato));

    /*
    $titulo = "Contrato enviado";
    $notas = "Se envió contrato al cliente, en espera de firma";
    $queryString = "
    INSERT INTO prospecto_acciones(
        titulo, 
        raccion, 
        inicio, 
        fin, 
        notas, 
        involucrado, 
        persona, 
        trato, 
        autor, 
        status, 
        status_trato
    ) 
    VALUES
    (
        '$titulo', 
        '6', 
        '$fecha_actualizada', 
        '$fecha_actualizada', 
        '$notas', 
        '$cerrador', 
        '$prospecto', 
        '$trato', 
        '$cerrador', 
        '1', 
        '4')";
    $query = $db->prepare($queryString);
    $query -> execute();
    */

    //$folio_contrato = $r_folio['id_folio'];
    $numContrato=1;//edson
    $folio_contrato = $numContrato;
    ///////////////// OBTENEMOS VARIABLES ///////////////////

    // POSICIÓN DE PRIMERAS COORDENADAS (LAS COORDENADAS SE AJUSTAN A LOS MILIMETROS DE LA HOJA)
    //Limite de hoja 0-216 (ancho) primer valor 0 representa borde

    //////////////// SE AÑADE FOLIO ///////////////
    $pdf->SetY(17.8);
    $pdf->SetX(169.8);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',12);
    $pdf->SetTextColor(255,0,0);
    $mensaje = $folio_contrato;
    $pdf->Cell(24, 6, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE FOLIO ///////////////

    //////////////// SE AÑADE NÚMERO DE COTIZACIÓN ///////////////
    $folioCotizacion=1;//edson
    $pdf->SetTextColor(0,0,0);
    $pdf->SetY(19.1);
    $pdf->SetX(125);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $folioCotizacion;
    $pdf->Cell(27.6, 4, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NÚMERO DE COTIZACIÓN ///////////////

    //////////////// SE AÑADE NÚMERO DE CLIENTE ///////////////
    $numCliente=1;//edson
    $pdf->SetY(24.1);
    $pdf->SetX(121.3);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $numCliente;
    $pdf->Cell(31, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NÚMERO DE CLIENTE ///////////////

    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////
    $persona="Persona Fisica";
    $pdf->SetY(33.4);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    if($persona == "Persona Fisica")
    {
        $mensaje = $nombre;
    }
    else
    {
        $mensaje = $nombre;
    }
    $pdf->Cell(78, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////

    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE ///////////////
    $pdf->SetY(51.6);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    if($persona == "Persona Moral")
    {
        $mensaje = $representanteLegal;
    }
    else
    {
        $mensaje = "N/A";
    }
    $pdf->Cell(80, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE ///////////////

    //////////////// SE AÑADE DATOS DE LA ESCRITURA ///////////////
    $pdf->SetY(65.4);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    if($persona == "Persona Moral")
    {
        $escritura_txt = number_format($escritura, 0, '.', ',');
        $mensaje = $escritura_txt;
    }
    else
    {
        $mensaje = "N/A";
    }
    $pdf->Cell(80, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE DATOS DE LA ESCRITURA ///////////////

    //////////////// SE AÑADE DIRECCIÓN DEL CLIENTE ///////////////
    $direccion="Direccion";//edson
    $pdf->SetY(79.4);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8.5);
    $mensaje = $direccion;
    $pdf->MultiCell(81, 3, $mensaje, 0, 0, 0);
    //////////////// SE AÑADE DIRECCIÓN DEL CLIENTE ///////////////

    //////////////// SE AÑADE TELEFONO ///////////////
    $pdf->SetY(88.4);
    $pdf->SetX(117);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $telefono;
    $pdf->Cell(63.5, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE TELEFONO ///////////////

    //////////////// SE AÑADE MODALIDAD ///////////////
    $modalidad="Leasing";//edson
    $pdf->SetY(92.9);
    $pdf->SetX(120);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $modalidad;
    $pdf->Cell(61.5, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE MODALIDAD ///////////////

    //////////////// SE AÑADE VALOR TOTAL ///////////////
    $pdf->SetY(99.9);
    $pdf->SetX(130.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);

    $valor_total_txt = number_format($valor_total, 2, '.', ',');
    if(is_null($valor_total_txt))
    {
        $valor_total_txt = "No disponible";
    }
    else
    {
        $valor_total_txt = "$ $valor_total_txt";
    }

    $mensaje = $valor_total_txt;
    $pdf->Cell(60, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE VALOR TOTAL ///////////////

    //////////////// SE AÑADE MENSUALIDAD ///////////////
    $pdf->SetY(104.4);
    $pdf->SetX(120.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);

    $mensualidad_txt = number_format($kitMensualidad, 2, '.', ',');
    if(is_null($mensualidad_txt))
    {
        $mensualidad_txt = "No disponible";
    }
    else
    {
        $mensualidad_txt = "$ $mensualidad_txt";
    }

    $mensaje = $mensualidad_txt;
    $pdf->Cell(70, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE MENSUALIDAD ///////////////

    //////////////// SE AÑADE RESIDUAL ///////////////
    $pdf->SetY(110.9);
    $pdf->SetX(123);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);

    $residual_txt = number_format($residual, 2, '.', ',');
    if(is_null($residual_txt))
    {
        $residual_txt = "No disponible";
    }
    else
    {
        $residual_txt = "$ $residual_txt";
    }

    $mensaje = $residual_txt;
    $pdf->Cell(67, 4, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE RESIDUAL ///////////////

    //////////////// SE AÑADE FORMA DE PAGO ///////////////
    $frecuenciaPago="Mensual";//edson
    $pdf->SetY(120.4);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $frecuenciaPago;
    $pdf->Cell(81, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE FORMA DE PAGO ///////////////

    //////////////// SE AÑADE ACUERDO DE PAGO ///////////////
    $acuerdoPago="Mensual";//edson
    $pdf->SetY(124.9);
    $pdf->SetX(125);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $acuerdoPago;
    $pdf->Cell(65, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE ACUERDO DE PAGO ///////////////

    //////////////// SE AÑADE FECHA INICIO ///////////////
    $pdf->SetY(129.5);
    $pdf->SetX(134);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $fecha_inicio_txt = dateToLabel($fechaInicio);
    $mensaje = $fecha_inicio_txt;
    $pdf->Cell(56, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE FECHA INICIO ///////////////

    //////////////// SE AÑADE FIN DE CONTRATO ///////////////
    $pdf->SetY(134);
    $pdf->SetX(139.2);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $fin_contrato_txt = dateToLabel($fin_contrato);
    $mensaje = $fin_contrato_txt;
    $pdf->Cell(51, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE FIN DE CONTRATO ///////////////

    //////////////// SE AÑADE NOMBRE DE CONTACTO 01 ///////////////
    $contacto1="Edson";//edson
    $pdf->SetY(143);
    $pdf->SetX(119);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $contacto1;
    $pdf->Cell(71.5, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CONTACTO 01 ///////////////

    //////////////// SE AÑADE NOMBRE DE TELEFONO 01 ///////////////
    $telefono1="Edson";//edson
    $pdf->SetY(148);
    $pdf->SetX(117);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $telefono1;
    $pdf->Cell(73.5, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NOMBRE DE TELEFONO 01 ///////////////

    //////////////// SE AÑADE NOMBRE DE CONTACTO 02 ///////////////
    $contacto2="Edson";//edson
    $pdf->SetY(152);
    $pdf->SetX(119);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $contacto2;
    $pdf->Cell(71.5, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CONTACTO 02 ///////////////

    //////////////// SE AÑADE NOMBRE DE TELEFONO 02 ///////////////
    $telefono2="Edson";//edson
    $pdf->SetY(156.7);
    $pdf->SetX(117);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $telefono2;
    $pdf->Cell(73.5, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NOMBRE DE TELEFONO 02 ///////////////

    $nombre_cerrador="Mauricio Castillo";
    //////////////// SE AÑADE NOMBRE DE CERRADOR ///////////////
    $pdf->SetY(185.7);
    $pdf->SetX(122.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',4.5);
    $mensaje = $nombre_cerrador;
    $pdf->Cell(30, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CERRADOR///////////////


    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////
    $pdf->SetY(185.7);
    $pdf->SetX(165);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',4.5);
    if($persona == "Persona Fisica")
    {
        $mensaje = "N/A";
    }
    else
    {
        $mensaje = $nombre;
    }
    $pdf->Cell(32, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////

    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE ///////////////
    $pdf->SetY(181.2);
    $pdf->SetX(169);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',4.5);
    if($persona == "Persona Moral")
    {
        $mensaje = $representanteLegal;
    }
    else
    {
        $mensaje = "$nombre";
    }
    $pdf->Cell(31, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE ///////////////

    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE O CLIENTE ///////////////
    $pdf->SetY(198.3);
    $pdf->SetX(112);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',6);
    if($persona == "Persona Moral")
    {
        $mensaje = $representanteLegal;
    }
    else
    {
        $mensaje = "$nombre";
    }
    $pdf->Cell(68, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE O CLIENTE ///////////////

    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE O CLIENTE ///////////////
    $pdf->SetY(227);
    $pdf->SetX(124);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',5);
    if($persona == "Persona Moral")
    {
        $mensaje = $representanteLegal;
    }
    else
    {
        $mensaje = "$nombre";
    }
    $pdf->Cell(74, 2, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE O CLIENTE ///////////////

    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////
    $pdf->SetY(235.8);
    $pdf->SetX(138.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',4.5);
    if($persona == "Persona Moral")
    {
        $mensaje = $nombre;
    }
    else
    {
        $mensaje = "N/A";
    }
    $pdf->Cell(58, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////

    // ENVIA EL PDF A DESPLEGARSE EN PANTALLA
    // SE PUEDE PONER EL NOMBRE DEL ARCHIVO PARA GUARDADO
    //$pdf->Output("contrato_leasing.pdf", 'I');


    $archivo = $pdf->Output("contrato_leasing.pdf", 'S');
    $archivo = base64_encode($archivo);

    //////////////// GUARDAMOS EL PDF DEL ARCHIVO QUE OBTUVIMOS ///////////////
    $ruta = $root."docs/digitalContracts/";
    $nombre_carpeta = $numContrato;
    $path = $ruta . $nombre_carpeta;

    if (!is_dir($path)) {
        if (mkdir($path, 0777)) {
            //echo "La carpeta se ha creado correctamente.";
            //////////////// GUARDAMOS EL PDF DEL ARCHIVO QUE OBTUVIMOS ///////////////
            $saveToPDF = base64_decode($archivo, true);
            $urlToSave = $path."/contrato_".$numContrato."_para_firma.pdf";
            file_put_contents($urlToSave, $saveToPDF);
        } else {
            //echo "No se pudo crear la carpeta.";
        }
    } else {
        //echo "La carpeta ya existe.";
    }

    // INICIA CARGA DE HERRAMIENTA DE API
 
    include ($root.'resources/api_trato/config.php');
    include ($root.'resources/api_trato/send_contract.php');
    
    // TERMINA CARGA DE HERRAMIENTA DE API

    //echo "$archivo";

    /*if($test_mode)
    {
        $correo_cerrador = 'mayolo_123@hotmail.com';
        $email_cliente = 'alexandro.a@acil.mx';
    }*/
    $correo_cerrador="edsonrobertorubiolopez@gmail.com";
    $participante1 = array(
        "name" => "Acil Mexico",
        "last_name" => "",
        "representative" => "",
        "obligation" => "Persona Física",
        "label" => "El asesor",
        "email" => "$correo_cerrador",
        "signOrder" => 0,
        "signatures" => array(
            array(
                "page" => 1,
                "top" => 700,
                "left" => 100,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            ),
            array(
                "page" => 2,
                "top" => 700,
                "left" => 100,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            ),
            array(
                "page" => 3,
                "top" => 700,
                "left" => 100,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            ),
            array(
                "page" => 4,
                "top" => 700,
                "left" => 100,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            ),
            array(
                "page" => 5,
                "top" => 460,
                "left" => 320,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            )
        )
    );
    
    if($persona == "Persona Moral")
    {
        $nombre_participante = $nombre;
        $obligation = "Persona Moral";
    }
    else
    {
        $nombre_participante = $nombre;
        $obligation = "Persona Física";
    }
    $representanteLegal="Edson";//edson
    $participante2 = array(
        "name" => "$nombre_participante",
        "last_name" => "",
        "representative" => "$representanteLegal",
        "obligation" => "$obligation",
        "label" => "El cliente:",
        "email" => "$email",
        "signOrder" => 0,
        "signatures" => array(
            array(
                "page" => 1,
                "top" => 700,
                "left" => 400,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            ),
            array(
                "page" => 2,
                "top" => 700,
                "left" => 400,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            ),
            array(
                "page" => 3,
                "top" => 700,
                "left" => 400,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            ),
            array(
                "page" => 4,
                "top" => 700,
                "left" => 400,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            ),
            array(
                "page" => 5,
                "top" => 460,
                "left" => 450,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            ),
            array(
                "page" => 5,
                "top" => 580,
                "left" => 400,
                "width" => 100,
                "height" => 100,
                "customSize" => true
            )
        )
    );

    $content = array(
        "name" => "Contrato de servicios ACIL México",
        "language" => "es",
        "expiryStartDate" => "$fechaInicio",
        "expiryEndDate" => "$fin_contrato",
        "externalId" => "$folio_contrato",
        "notificationType" => "email",
        "signatureType" => "autograph",
        "blockchainType" => "none",
        "file" => "data:application/pdf;base64,$archivo",
        "participants" => array($participante1,$participante2),
    );

    $prueba_conexion= crea_contrato($link_api,$api_key,$content);
    $prueba_conexion_decrypt = json_decode($prueba_conexion);

    //var_dump($prueba_conexion_decrypt);

    /*
    $messageSuccess = "Contrato enviado con éxito";
    include_once($root."templates/$theme/successPage.php");
    */
?>