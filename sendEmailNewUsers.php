<?php
    #CARGA DE RECURSOS
    include_once('config/config.php');
    include_once('config/dbConf.php');
    include_once('functions.php');
    include $root."resources/PHPMailer/src/Exception.php";
	include $root."resources/PHPMailer/src/PHPMailer.php";
	include $root."resources/PHPMailer/src/SMTP.php";
    
    #FUNCIONES
    //Crea la contraseña de acceso en base al nombre del socio
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
    //Envia correo de bienvenidan al socio o socios
    function sendMails($nombre, $email, $idColaborador, $pass)
    {
        global $root, $mailSender, $mailHost, $mailUser, $mailPass;
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
    }

    $db=conexionPdo();

    $socios = array(
        array(
            "nombre" => "Krishna",
            "apellido" => "Lopez Hernandez",
            "email" => "edsonrobertorubiolopez@gmail.com"
        ),
        array(
            "nombre" => "Roberto",
            "apellido" => "Rubio Lopez",
            "email" => "edson.r@acil.mx"
        )/*,
        array(
            "nombre" => "Jonathan Omar",
            "apellido" => "Elizalde Aguirre",
            "email" => "jonathan.elizalde021@gmail.com"
        ),
        array(
            "nombre" => "Oscar",
            "apellido" => "Novelo Stubbe",
            "email" => "oscar@easdepot.com.mx"
        ),
        array(
            "nombre" => "Gabriela",
            "apellido" => "Ramirez James",
            "email" => ""
        ),
        array(
            "nombre" => "Guillermo Alejandro",
            "apellido" => "Meza Arroyo",
            "email" => "baksterk@hotmail.com"
        ),
        array(
            "nombre" => "Jorge Antonio",
            "apellido" => "Martinez Bonola",
            "email" => "bonola.jorge.m@gmail.com"
        ),
        array(
            "nombre" => "Yadira",
            "apellido" => "Hernandez Hernandez",
            "email" => "yadira.hh.ch@gmail.com"
        ),
        array(
            "nombre" => "Lizethe",
            "apellido" => "Sanchez Secundino",
            "email" => "lizethss63@gmail.com"
        ),
        array(
            "nombre" => "Miguel Angel",
            "apellido" => "Picazo Morales",
            "email" => ""
        ),
        array(
            "nombre" => "Edson Roberto",
            "apellido" => "Rubio López",
            "email" => "ing.edson.rubio@outlook.com"
        ),
        array(
            "nombre" => "Luis Bersain",
            "apellido" => "Coronado Samoran",
            "email" => "luis_bersis@hotmail.com"
        ),
        array(
            "nombre" => "Berenice",
            "apellido" => "Nuñez Peña",
            "email" => "benupe.1998@gmail.com"
        ),
        array(
            "nombre" => "Adrian",
            "apellido" => "Sanchez Vazquez",
            "email" => "adrian2172004789@gmail.com"
        )*/
        
    );
    
    $contador=count($socios);
    
    for($i=0; $i<=$contador-1; $i++)
    {
        //Consulta para insertar nuevo usuario
        $consultaStr="INSERT INTO usuarios(username, pass, email, estatus) VALUES (?,?,?,?)";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$socios[$i]["email"],$socios[$i]["email"],$socios[$i]["email"],0]);

        //Consulta para extraer id_usuario WHERE $email
        $consultaStr="SELECT * FROM usuarios WHERE email=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$socios[$i]["email"]]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        $idUsuario=$dataConsulta["id_usuario"];

        //Consulta para insertar COLABORADOR
        $consultaStr="INSERT INTO colaboradores (usuario, nombre, puesto, rango, ruta_foto, estatus, sucursal) VALUES (?,?,?,?,?,?,?)";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$idUsuario, $socios[$i]["nombre"]." ".$socios[$i]["apellido"], 14, 'Socio Acil', 'cilo.jpg', 0,1]);

        //Consulta para extraer id_colaborador
        $consultaStr="SELECT * FROM colaboradores WHERE nombre=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$socios[$i]["nombre"]]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        $idColaborador=$dataConsulta["id_colaborador"];

        //Funcion para crear contraseña
        $pass=createPass($socios[$i]["nombre"], $socios[$i]["apellido"]);

        $consultaStr="UPDATE usuarios SET username=?, pass=? WHERE id_usuario=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$idColaborador, $pass, $idUsuario]); 
        
        $carpeta = $root."docs/partners/".$idUsuario;
        if (!is_dir($carpeta)) 
        {
            if (mkdir($carpeta, 0777)) 
            { 
                chmod($carpeta, 0777);
                echo "Carpeta para el usuario ".$idUsuario." CREADA<br>";
            } 
            else 
            { 
                echo "Hubo un error al crear la carpeta.";
            }
        } 
        else 
        {
            echo "La carpeta del usuario ".$idUsuario." ya existe<br>";
        }

        ////////////////// ENVIAMOS EMAILS DE BIENVENIDA /////////////////////
        sendMails($socios[$i]["nombre"], $socios[$i]["email"], $idColaborador, $pass);

        echo "SOCIO: ".$socios[$i]["nombre"]." ".$socios[$i]["apellido"]." ---> Completado<br><br>";
    }
        
?>