<?php
    //Envia correo de bienvenidan al socio o socios
    //CREA ARRAY PARA RECIPIENTS
    $recipients = array();   
    $nombreUsuario = $nombre;
    $emailUsuario =  $email;
    $dataUserMail = array("email" => "{$emailUsuario}", "name" => "{$nombreUsuario}");
    array_push($recipients, $dataUserMail);

    #ENVIO DE CORREO
    ##SE DEFINEN VARIABLES
    //$recipients = array(array("email" => "{$emailDestino}", "name" => "{$nombreDestino}"));
    $mailSubject = "Bienvenido a Socios ACIL";
    $mailPath = $root.'templates/acil/email/mailNewUser.php';
    $mailData = array(
        array("var_name" => "nombreUsuario", "var_val" => "{$nombreUsuario}"),
        array("var_name" => "idColaborador", "var_val" => "{$idColaborador}"),
        array("var_name" => "pass", "var_val" => "{$pass}")
    );
    ##SE EJECUTA FUNCIÓN
    sendEmail($recipients, $mailSender, $mailSubject, $mailPath, $mailData, $mailHost, $mailUser, $mailPass);
?>
    