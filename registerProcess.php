<?php
    include_once('config/config.php');
    include_once('config/dbConf.php');
    include_once('functions.php');
    include $root."resources/PHPMailer/src/Exception.php";
	include $root."resources/PHPMailer/src/PHPMailer.php";
	include $root."resources/PHPMailer/src/SMTP.php";

    if (isset($_POST["nombre"]) && isset($_POST["calle"]) && isset($_POST["numero"]) && isset($_POST["colonia"]) && isset($_POST["email"]) && isset($_POST["phone"])){
        $nombre=   $_POST["nombre"];
        $calle=    $_POST["calle"];
        $numero=   $_POST["numero"];
        $colonia=  $_POST["colonia"];
        $email=    $_POST["email"];
        $telefono= $_POST["phone"];
    }

    $db=conexionPdo();

    //Consulta para buscar si existe el usuario
    $consultaStr="SELECT id_usuario, username, pass, email, estatus FROM usuarios WHERE username=?";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute([$email]);
    if ($consulta->rowCount() > 0) {//El USUARIO EXISTE
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $idUsuario = $fila['id_usuario'];
            $username = $fila['username'];
            $pass = $fila['pass'];
        }

        //Consulta para revisar ¿EXISTE EL COLABORADOR?
        $consultaStr="SELECT * FROM colaboradores WHERE usuario=? LIMIT 1";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$idUsuario]);
        if ($consulta->rowCount() > 0) {//El COLABORADOR EXISTE
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $idColaborador = $fila['id_colaborador'];
            }
            //Consulta para agregar contraseña a usuario
            $pass="Acil".$idColaborador."123@";
            $consultaStr="UPDATE usuarios SET pass='$pass' WHERE id_usuario=?";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute([$idUsuario]);    
        }else{//El COLABORADOR NO EXISTE
            //Consulta para insertar COLABORADOR
            $consultaStr="INSERT INTO colaboradores (usuario, nombre, puesto, rango, ruta_foto, estatus, sucursal) VALUES ('$idUsuario','$nombre',14,'Socio Acil','cilo.jpg',0,1)";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute();

            //Consulta para extraer id_colaborador
            $consultaStr="SELECT * FROM colaboradores WHERE nombre=?";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute([$nombre]);
            $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
            $idColaborador=$dataConsulta["id_colaborador"];

            //Consulta para agregar contraseña a usuario
            $pass="Acil".$idColaborador."123@";
            $consultaStr="UPDATE usuarios SET pass='$pass' WHERE id_usuario=?";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute([$idUsuario]); 
        } 
    }
    else {//El USUARIO NO EXISTE
    
    //Consulta para insertar nuevo usuario
    $consultaStr="INSERT INTO usuarios(username, pass, email, estatus) VALUES (?,?,?,?)";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute([$email,$email,$email,0]);

    //Consulta para extraer id_usuario WHERE $email
    $consultaStr="SELECT * FROM usuarios WHERE email=?";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute([$email]);
    $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
    $idUsuario=$dataConsulta["id_usuario"];

    //Consulta para insertar COLABORADOR
    $consultaStr="INSERT INTO colaboradores (usuario, nombre, puesto, rango, ruta_foto, estatus, sucursal) VALUES ('$idUsuario','$nombre',14,'Socio Acil','cilo.jpg',0,1)";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute();

    //Consulta para extraer id_colaborador
    $consultaStr="SELECT * FROM colaboradores WHERE nombre=?";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute([$nombre]);
    $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
    $idColaborador=$dataConsulta["id_colaborador"];

    //Consulta para agregar contraseña a usuario
    $pass="Acil".$idColaborador."123@";
    $consultaStr="UPDATE usuarios SET pass='$pass' WHERE id_usuario=?";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute([$idUsuario]); 
    }

    $carpeta = $root."docs/users/".$idUsuario;
    if (!is_dir($carpeta)) {
        if (mkdir($carpeta, 0777)) { 
            chmod($carpeta, 0777);
        } else { 
            //echo "Hubo un error al crear la carpeta.";
        }
    } else {
        //echo "La carpeta ya existe.";
    }
    
    ////////////////// GENERAMOS TRATO /////////////////////
    require($root.'resources/PDFGenerator/SendToTrato.php');

    ////////////////// ENVIAMOS EMAIL DE BIENVENIDA /////////////////////
    require($root.'sendMailWelcome.php');

    ////////////////// CARGAMOS FORMULARIO DE CARGA DE DOCUMENTOS /////////////////////
    require('templates/acil/uploadFiles.php');
?>