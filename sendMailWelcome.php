<?php
    //CREA ARRAY PARA RECIPIENTS
    $recipients = array();   
    $nombreUsuario = $nombre;
    $emailUsuario =  $email;
    $dataUserMail = array("email" => "{$emailUsuario}", "name" => "{$nombreUsuario}");
    array_push($recipients, $dataUserMail);

    #ENVIO DE CORREO
    ##SE DEFINEN VARIABLES
    //$recipients = array(array("email" => "{$emailDestino}", "name" => "{$nombreDestino}"));
    $mailSubject = "Registro de Usuario (#{$idUsuario})";
    $mailPath = $root.'templates/acil/email/mailNewUser.php';
    $mailData = array(
        array("var_name" => "nombre", "var_val" => "{$nombre}"),
        array("var_name" => "emailUsuario", "var_val" => "{$emailUsuario}"),
        array("var_name" => "pass", "var_val" => "{$pass}")
    );
   

    ##SE EJECUTA FUNCIÓN
    sendEmail($recipients, $mailSender, $mailSubject, $mailPath, $mailData, $mailHost, $mailUser, $mailPass);

?>