<?php
if (isset($_POST['idioma']) && !empty($_POST['idioma'])) {
    //Se hace el llamado del modelo de conexion y consultas
    require_once '../modelo/mysql.php';

    //Se capturan datos del form
    $idioma = $_POST['idioma'];
    $id = $_POST['id'];


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
        $clave = 'miranda123';
        //Metodo de encriptaciÃ³n
        $method = 'aes-256-cbc';
        // Puedes generar una diferente usando la funcion $getIV()
        $iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");
        return base64_decode(openssl_decrypt($valor, $method, $clave, false, $iv));
    };



    //Se instancia la clase
    $mysql = new MySql();

    //Se hace uso del metodo
    $mysql->conectar();

    //Se guarda la respuesta de la consulta en la variable 
    $consulta = $mysql->efectuarConsulta("INSERT INTO peliculas.idiomas (idioma) VALUE ('" . $idioma . "')");

    //Se desconect de la base de datos
    $mysql->desconectar();

    header("Location: ../agregarIdiomas.php");
    session_start();
    $_SESSION['mensaje2'] = "Insercion Completada";
    $_SESSION['mensaje'] = "Idioma Insertado Correctamente";
} else {
    header("Location: ../agregarIdiomas.php");
    session_start();
    $_SESSION['mensajeErr2'] = "Fallo en la Insercion";
    $_SESSION['mensajeErr'] = "Por favor llene todos los campos";
}