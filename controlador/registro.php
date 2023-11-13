<?php
if (isset($_POST['usuarioRegistro']) && !empty($_POST['usuarioRegistro']) && isset($_POST['contraseñaRegistro']) && !empty($_POST['contraseñaRegistro'])) {
    //Se hace el llamado del modelo de conexion y consultas
    require_once '../modelo/mysql.php';

    //Se capturan datos del form
    $user = $_POST['usuarioRegistro'];
    $pass = $_POST['contraseñaRegistro'];


    //ConfiguraciÃ³n del algoritmo de encriptaciÃ³n
    //Debes cambiar esta cadena, debe ser larga y unica
    //nadie mas debe conocerla
    $encriptar = function ($valor) {
        $clave = 'miranda123';
        //Metodo de encriptaciÃ³n
        $method = 'aes-256-cbc';
        // Puedes generar una diferente usando la funcion $getIV()
        $iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");
        return openssl_encrypt(base64_encode($valor), $method, $clave, false, $iv);
    };
    /*
     Desencripta el texto recibido
     */
    $desencriptar = function ($valor) {
        $clave = 'Adso2501875';
        //Metodo de encriptaciÃ³n
        $method = 'aes-256-cbc';
        // Puedes generar una diferente usando la funcion $getIV()
        $iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");
        return base64_decode(openssl_decrypt($valor, $method, $clave, false, $iv));
    };
    $mysql = new MySql();
    //Se instancia la clase
    $mysql->conectar();
    $consulta2 = $mysql->efectuarConsulta("SELECT * FROM peliculas.usuarios WHERE peliculas.usuarios.user ='" . $user . "'");
    $mysql->desconectar();

    if (mysqli_num_rows($consulta2) > 0) {
        header("Location: ../resgitro.php");
        session_start();
        $_SESSION['mensajeErr'] = "El usuario ya existe en la Base de Datos";
        $_SESSION['mensaje2Err'] = "Fallo al insertar";
    } else {
        $mysql->conectar();
        //Se guarda la respuesta de la consulta en la variable 
        $consulta = $mysql->efectuarConsulta("INSERT INTO peliculas.usuarios (user,pass) VALUES ('" . $user . "','" . $encriptar($pass) . "')");
        //Se desconect de la base de datos
        $mysql->desconectar();

        header("Location: ../login.php");
        session_start();
        $_SESSION['mensaje'] = "Usuario Creado Correctamente";
        $_SESSION['mensaje2'] = "Informacion Insertada, Inicia Session";
    }

    //Se hace uso del metodo
} else {
    header("Location: ../resgitro.php");
    session_start();
    $_SESSION['mensajeErr'] = "Por favor llene todos los campos";
    $_SESSION['mensaje2Err'] = "Fallo al insertar";
}

