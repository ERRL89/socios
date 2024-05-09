<?php
///////////////// SE CREA OBJETO reciboPDF /////////////////
$datosBancarios = new pdf();

////////////// SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS //////////////

$pagecount = $datosBancarios->setSourceFile($root."resources/cotizadores/cotizadoc/hoja_1.pdf");

////////////// SE IMPORTA LA HOJA QUE SE USARÁ DE PLANTILLA //////////////
$tpl = $datosBancarios->importPage(1);

/////// DESIGNAMOS EL TAMAÑO DE LA PLANTILLA DESDE LA HOJA IMPORTADA ///////
$size = $datosBancarios->getTemplateSize($tpl);
/////// DESIGNAMOS EL TAMAÑO DE LA PLANTILLA DESDE LA HOJA IMPORTADA ///////

///////// AÑADIMOS UNA PÁGINA DESIGNANDO EL TAMAÑO DEL DOCUMENTO /////////
////////////// (LETTER = CARTA, 'P' = Portrait ~ vertical) //////////////
$datosBancarios->AddPage('P', 'LETTER');
///////// AÑADIMOS UNA PÁGINA DESIGNANDO EL TAMAÑO DEL DOCUMENTO /////////

////////////// CARGAMOS LA PLANTILLA EN NUESTRA NUEVA PÁGINA //////////////
$datosBancarios->useTemplate($tpl);
////////////// CARGAMOS LA PLANTILLA EN NUESTRA NUEVA PÁGINA //////////////

// FECHA
$datosBancarios->SetFont('helvetica', '', 13);
$datosBancarios->SetTextColor(0, 0, 0); // Color blanco para el texto
$datosBancarios->SetXY(160, 40); // Posición x, posición y
$mensaje=$fechaInicio;
$datosBancarios->Cell(0, 10, 'Fecha: '.$mensaje, 0, 1, '');

// TEXTO DATOS BANCARIOS
$datosBancarios->SetFont('helvetica', 'B', 13);
$datosBancarios->SetTextColor(0, 0, 0); // Color blanco para el texto
$datosBancarios->SetXY(30, 60); // Posición x, posición y
$datosBancarios->Cell(0, 10, 'DATOS BANCARIOS', 0, 1, '');

// TEXTO NOMBRE
$datosBancarios->SetFont('helvetica', 'B', 11);
$datosBancarios->SetTextColor(0, 0, 0); // Color blanco para el texto
$datosBancarios->SetXY(30, 70); // Posición x, posición y
$datosBancarios->Cell(0, 10, 'Estimado/a: '.$nombre, 0, 1, '');

// TEXTO DATOS BANCARIOS
$datosBancarios->SetFont('helvetica', '', 11);
$datosBancarios->SetTextColor(0, 0, 0); // Color blanco para el texto
$datosBancarios->SetXY(30, 85); // Posición x, posición y
$datosBancarios->Cell(0, 10, 'Te compartimos las siguientes referencias de pago:', 0, 1, '');


$datosBancarios->Output($root."docs/digitalContracts/datos_bancarios.pdf", 'F');



