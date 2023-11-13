<?php
if (
    isset($_POST['idUser']) && !empty($_POST['idUser'])
    && isset($_POST['nombrePelicula']) && !empty($_POST['nombrePelicula'])
    && isset($_POST['descripcionPelicula']) && !empty($_POST['descripcionPelicula'])
    && isset($_POST['checkGenero']) && !empty($_POST['checkGenero'])
    && isset($_POST['checkIdioma']) && !empty($_POST['checkIdioma'])
) {

    $idUsuario = $_POST['idUser'];
    $nombrePeli = $_POST['nombrePelicula'];
    $descripcionPeli = $_POST['descripcionPelicula'];
    $fecha_actual = date('Y-m-d');

    require_once "../modelo/mysql.php";
    $mysql = new MySql();

    $mysql->conectar();
    $consultaExiste = $mysql->efectuarConsulta("SELECT * FROM peliculas.peliculas WHERE peliculas.peliculas.nombre_Pelicula = '" . $nombrePeli . "'");
    $mysql->desconectar();
    if (mysqli_num_rows($consultaExiste) > 0) {
        header("Location: ../agregarPeliculas.php");
        session_start();
        $_SESSION['errorTitu'] = "Error al Insertar";
        $_SESSION['error'] = "Ya existe una pelicula con este nombre";
    } else {
        ////////////////////
        //INSERTO PELICULA//
        ////////////////////
        //Se hace uso del metodo
        $mysql->conectar();
        //Se guarda la respuesta de la consulta en la variable 
        $consulta = $mysql->efectuarConsulta("INSERT INTO peliculas.peliculas (nombre_Pelicula, descripcion_Pelicula, Usuarios_idUsuario, fecha) VALUES ('" . $nombrePeli . "','" . $descripcionPeli . "','" . $idUsuario. "','" . $fecha_actual . "')");
        //Se desconect de la base de datos
        $mysql->desconectar();
        ////////////////////
        //INSERTO PELICULA//
        ////////////////////
        //---------------------------//
        /////////////////////////////
        //TRAIGO EL MAX ID PELICULA//
        /////////////////////////////
        $mysql->conectar();
        //Se guarda la respuesta de la consulta en la variable 
        $consulta2 = $mysql->efectuarConsulta("SELECT MAX(idPelicula) AS 'idMaximo' FROM peliculas.peliculas");
        //Se desconect de la base de datos
        $mysql->desconectar();

        $fila = mysqli_fetch_array($consulta2);

        $idMaximo = $fila['idMaximo'];
        /////////////////////////////
        //TRAIGO EL MAX ID PELICULA//
        /////////////////////////////
        //--------------------------------------//
        ////////////////////////////
        ////INSERTO LOS GENEROS////
        ////////////////////////////
        $arregloGenero = $_POST['checkGenero'];
        $largoArregloGenero = count($arregloGenero);
        for ($i = 0; $i < $largoArregloGenero; $i++) {
            $mysql->conectar();
            //Se guarda la respuesta de la consulta en la variable 
            $consulta2 = $mysql->efectuarConsulta("INSERT INTO peliculas.generos_has_peliculas (Generos_idGenero,Peliculas_idPelicula) VALUES (" . $arregloGenero[$i] . "," . $idMaximo . ")");
            //Se desconect de la base de datos
            $mysql->desconectar();
        }
        ////////////////////////////
        ////INSERTO LOS GENEROS////
        ////////////////////////////
        //-------------------------------------//
        ////////////////////////////
        ////INSERTO LOS IDIOMAS////
        ////////////////////////////
        $arregloIdioma = $_POST['checkIdioma'];
        $largoArregloIdioma = count($arregloIdioma);
        for ($i = 0; $i < $largoArregloIdioma; $i++) {
            $mysql->conectar();
            //Se guarda la respuesta de la consulta en la variable 
            $consulta2 = $mysql->efectuarConsulta("INSERT INTO peliculas.peliculas_has_idiomas (Peliculas_idPelicula,Idiomas_idIdioma) VALUES (" . $idMaximo . "," . $arregloIdioma[$i] . ")");
            //Se desconect de la base de datos
            $mysql->desconectar();
        }
        ////////////////////////////
        ////INSERTO LOS IDIOMAS////
        ////////////////////////////
        //----------------------------------//
        header("Location: ../listarPeliculas.php");
        session_start();
        $_SESSION['mensajeTitu'] = "Insercion Realizada";
        $_SESSION['mensaje'] = "La pelicula fue insertada correctamente";
    }
} else {
    header("Location: ../agregarPeliculas.php");
    session_start();
    $_SESSION['errorTitu'] = "Error al Insertar";
    $_SESSION['error'] = "Por favor llene todos los campos antes de enviar la informacion";
}
