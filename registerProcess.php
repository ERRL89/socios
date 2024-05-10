<?php
    #SE CARGAN RECURSOS
    include_once('config/config.php');
    include_once('config/dbConf.php');
    include_once('functions.php');
    include $root."resources/PHPMailer/src/Exception.php";
	include $root."resources/PHPMailer/src/PHPMailer.php";
	include $root."resources/PHPMailer/src/SMTP.php";

    function createPass($nombre, $apellido)
    {
        //Extrae 1er nombre para contraseña
        $partesNombre = explode(" ", $nombre);
        //print_r($partesNombre); echo "<br>";
        $nombrePass=ucfirst($partesNombre[0]);
        //echo $nombrePass."<br><br>";

        //Extrae 1er apellido para contraseña
        $partesApellido = explode(" ", $apellido);
        //print_r($partesApellido); echo "<br>";
        $longApellido=count($partesApellido);

        for($i=0;$i<=$longApellido-1;$i++)
        {
            if(strlen($partesApellido[$i])>3)
            {
                    $apellidoPass=ucfirst($partesApellido[$i]);
                    //echo $apellidoPass;
                    break;
            }
        }

        $pass=$nombrePass.$apellidoPass."123@";
        //echo "<br><br>".$pass;
        return $pass;
    }

    #SE RECIBEN VARIABLES DESDE REGISTER FORM
    if (isset($_POST["nombre"]))/*-------->*/{ $nombre= $_POST["nombre"]; }
    if (isset($_POST["apellido"]))/*------>*/{ $apellido= $_POST["apellido"]; }
    if (isset($_POST["referido"]))/*------>*/{ $referido= $_POST["referido"]; }
    if (isset($_POST["nacionalidad"]))/*-->*/{ $nacionalidad= $_POST["nacionalidad"]; }
    if (isset($_POST["calle"]))/*--------->*/{ $calle= $_POST["calle"]; }
    if (isset($_POST["numero"]))/*-------->*/{ $numero= $_POST["numero"]; }
    if (isset($_POST["cp"]))/*------------>*/{ $cp= $_POST["cp"]; }
    if (isset($_POST["municipio"]))/*----->*/{ $municipio= $_POST["municipio"]; }
    if (isset($_POST["estado"]))/*-------->*/{ $estado= $_POST["estado"]; }
    if (isset($_POST["colonia"]))/*------->*/{ $colonia= $_POST["colonia"]; }
    if (isset($_POST["telefono"]))/*------>*/{ $telefono= $_POST["telefono"]; }
    if (isset($_POST["email"]))/*--------->*/{ $email= $_POST["email"]; }
    if (isset($_POST["clabe"]))/*--------->*/{ $clabe= $_POST["clabe"]; }
    if (isset($_POST["rfc"]))/*----------->*/{ $rfc= $_POST["rfc"]; }

    $db=conexionPdo();

    $userExist=0;

    //Consulta para buscar si existe el usuario validado EMAIL
    $consultaStr="SELECT id_usuario, username, pass, email, estatus FROM usuarios WHERE email=?";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute([$email]);

    //El USUARIO EXISTE
    if ($consulta->rowCount() > 0) 
    {
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) 
        {
            $idUsuario = $fila['id_usuario'];
            $username = $fila['username'];
            $pass = $fila['pass'];
        }
        //Consulta para revisar ¿EXISTE EL COLABORADOR?
        $consultaStr="SELECT * FROM colaboradores WHERE usuario=? LIMIT 1";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$idUsuario]);
        //El COLABORADOR EXISTE
        if ($consulta->rowCount() > 0) 
        {
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) 
            {
                $idColaborador = $fila['id_colaborador'];
            }
            //MENSAJE EL USUARIO YA EXISTE, INGRESE CON SUS CREDENCIALES DE INICIO DE SESION
            $userExist=1;
            $messageSuccess="
                             <h4>El usuario ya existe, ingrese con sus credenciales de inicio de sesión</h4>
                             <a href='https://acil.mx/intranet' class='btn btn-primary btn-custom'>Inicia sesión</a>
                            ";
            require($root.'templates/acil/successPage.php');
        }
        //El COLABORADOR NO EXISTE
        else
        {
            //Consulta para insertar COLABORADOR
            $consultaStr="INSERT INTO colaboradores (usuario, nombre, puesto, rango, ruta_foto, estatus, sucursal) VALUES (?,?,?,?,?,?,?)";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute([$idUsuario, $nombre." ".$apellido, 14, 'Socio Acil', 'cilo.jpg', 0, 1]);

            //Consulta para extraer id_colaborador
            $consultaStr="SELECT * FROM colaboradores WHERE usuario=?";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute([$idUsuario]);
            $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
            $idColaborador=$dataConsulta["id_colaborador"];

            //Consulta para agregar contraseña a usuario
            $pass=createPass($nombre, $apellido);

            $consultaStr="UPDATE usuarios SET username=?, pass=? WHERE id_usuario=?";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute([$idColaborador, $pass, $idUsuario]); 
        } 
    }
    
    //El USUARIO NO EXISTE
    else 
    {
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
        $consultaStr="INSERT INTO colaboradores (usuario, nombre, puesto, rango, ruta_foto, estatus, sucursal) VALUES (?,?,?,?,?,?,?)";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$idUsuario, $nombre." ".$apellido, 14, 'Socio Acil', 'cilo.jpg', 0, 1]);

        //Consulta para extraer id_colaborador
        $consultaStr="SELECT * FROM colaboradores WHERE usuario=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$idUsuario]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        $idColaborador=$dataConsulta["id_colaborador"];

        //Consulta para agregar contraseña a usuario
        $pass=createPass($nombre, $apellido);

        $consultaStr="UPDATE usuarios SET username=?, pass=? WHERE id_usuario=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$idColaborador, $pass, $idUsuario]); 
    }

    //Si el usuario no existe, se genera contrato, envia email y muestra CARGA DE DOCUMENTOS
    if($userExist==0)
    {
        $carpeta = $root."docs/partners/".$idUsuario;
        #CREA CARPETA PARA ALMACENAR DOCUMENTACION DE USUARIO
        if (!is_dir($carpeta)) 
        {
            if (mkdir($carpeta, 0777)) 
            { 
                chmod($carpeta, 0777);
            } 
            else 
            { 
                //echo "Hubo un error al crear la carpeta.";
            }
        } 
        else 
        {
            //echo "La carpeta ya existe.";
        }
        ////////////////// GENERAMOS TRATO /////////////////////
        //require($root.'resources/PDFGenerator/SendToTrato.php');
        ////////////////// ENVIAMOS EMAIL DE BIENVENIDA /////////////////////
        require($root.'sendMailWelcome.php');
        ////////////////// CARGAMOS FORMULARIO DE CARGA DE DOCUMENTOS /////////////////////
        require('templates/acil/uploadFiles.php');
    }
    
?>