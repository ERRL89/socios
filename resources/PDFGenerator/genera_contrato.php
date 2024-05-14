<?php

/*//Datos para prueba de creacion de contrato
    include_once('../../config/config.php');
    date_default_timezone_set('America/Mexico_City');
    $fecha = date("d-m-Y");

    $nombre="Edson Roberto";
    $apellido= "Rubio López";
    $referido="399465";
    $nacionalidad= "Mexicana";
    $calle="Cumbres de Maltrata"; 
    $numero="124"; 
    $cp="54040"; 
    $municipio="Tlalnepantla"; 
    $estado= "Estado de México";
    $colonia="Los Pirules";
    $telefono="5588093678";
    $email="ing.edson.rubio@outlook.com";
    $clabe="01234567890"; 
    $rfc="RULE8908144C8";*/

header("Cache-Control: no-cache, must-revalidate");
setlocale(LC_TIME, "spanish");

/////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////
use setasign\Fpdi;
require_once($root.'resources/tcpdf/tcpdf.php');
require_once($root.'resources/fpdi/autoload.php');

///////////////// SE INSTANCIA LA CLASE DEL PDF /////////////////
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

///////////////// SE CREA OBJETO reciboPDF /////////////////
$reciboPDF = new pdf();

////////////// SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS //////////////
$pagecount = $reciboPDF->setSourceFile($root."resources/PDFGenerator/contrato.pdf");
$h=4; //margen

for($i = 1; $i <=7; $i++)
{
    $tpl = $reciboPDF->importPage($i);
    $size = $reciboPDF->getTemplateSize($tpl);
    $reciboPDF->AddPage('P', 'A4');
    $reciboPDF->useTemplate($tpl);

    if($i==3)//INSERTA DATOS EN PAGINA 3
    {
        //NOMBRE
        $reciboPDF->SetFont('helvetica', '', 11);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(33, 191-$h); 
        $texto = $nombre." ".$apellido;
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');
    }

    if($i==4)//INSERTA DATOS EN PAGINA 4
    {
        //NOMBRE
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 42); 
        $texto = $nombre." ".$apellido;
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');

        //REPRESENTANTE LEGAL
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 56); 
        $texto = "N/A";
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');

        //NACIONALIDAD
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 72); 
        $texto = $nacionalidad;
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');

        //RFC
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 87); 
        $texto = $rfc;
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');

        //COSTO DE MEMBRESIA
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 102); 
        $texto = "N/A";
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');

        //CLABE INTERBANCARIA
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 117); 
        $texto = $clabe;
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');

        //FECHA
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 133); 
        $texto = $fecha;
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');

        //DIRECCION
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 145);
        $texto = $calle." ".$numero.", ".$colonia. ", ".$cp." ".$municipio.", ".$estado;
        $anchoCelda = 88; 
        $alturaCelda = 12; 
        // Crear la celda con el texto ajustado en múltiples líneas
        $reciboPDF->MultiCell($anchoCelda, $alturaCelda, $texto, 0, 'L', false);

        //CORREO ELECTRONICO
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 164); 
        $texto = $email;
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');

        //TELEFONO
        $reciboPDF->SetFont('helvetica', '', 12);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetXY(97, 179); 
        $texto = $telefono;
        $anchoTexto = $reciboPDF->GetStringWidth($texto); // Sin margen adicional
        $reciboPDF->Cell($anchoTexto, $h, $texto, 0, 0, '');
    }
}

//GENERA ARCHIVO PDF
$reciboPDF->Output($root."docs/partners/".$idUsuario."/contrato_para_firma_".$idUsuario.".pdf", 'F');

?>