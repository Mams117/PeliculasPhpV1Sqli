<?php
session_start();
//CONTROLA EL INICIO DE SESION
//SE VREIFICA QUE EXITAN DATOS
if (isset($_POST['usuario']) && !empty($_POST['usuario']) && isset($_POST['contraseña']) && !empty($_POST['contraseña'])) {
    //Se hace el llamado del modelo de conexion y consultas
    require_once '../modelo/mysql.php';
    //Se capturan datos del form
    $user = $_POST['usuario'];
    $pass = $_POST['contraseña'];

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
    $consulta = $mysql->efectuarConsulta("SELECT peliculas.usuarios.idUsuario, peliculas.usuarios.user, peliculas.usuarios.pass FROM peliculas.usuarios WHERE peliculas.usuarios.user='" . $user . "' && peliculas.usuarios.pass='" . $encriptar($pass) . "'");

    //Se desconect de la base de datos
    $mysql->desconectar();

    //Captura los datos de la consulta, captura una sola fila

}

if (mysqli_num_rows($consulta) > 0) {
    require_once '../modelo/usuario.php';
    $fila = mysqli_fetch_assoc($consulta);
    //$usuario = new usuarios();
    $id = $fila['idUsuario'];
    $user = $fila['user'];
    //$usuario->setId($id);
    //$usuario->setUsuario($user);
    //inicie sesion
    //session_start();
    $_SESSION['idUsuario'] = $id;
    $_SESSION['user'] = $user;
    $_SESSION['inicio'] = true;
    //Traigo el modelo con la clase usuarios
    //require_once '../modelo/usuarios.php';
    header("Location: ../dashboard.php");
} else {
    header("Location: ../login.php");
    $_SESSION['error'] = "Usuario o Contraseña incorrecta";
    $_SESSION['error2'] = "Fallo de Inicion de Session";
}
