<?php

////////////////////////////////////////////////////////////////////////////////////
//                                                                                //
// SE INCLUYE LINKS DE CONFIGURACIÓN, PARA CAMBIAR RUTAS, EDITA EL ARCHIVO        //
// "config.php" NO EDITES LAS VARIABLES DE URL Y CLAVE API DESDE AQUÍ             //
//                                                                                //
////////////////////////////////////////////////////////////////////////////////////

function crea_contrato($link_api,$api_key,$content)
{
    $url = $link_api."v2/create/contract";
    $headers[] = "Accept: application/json";
    $headers[] = "apikey: $api_key";

    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($content));
    $result = curl_exec($ch);


    return $result;
}

?>