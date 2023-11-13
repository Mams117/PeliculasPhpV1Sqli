<?php
$idPelicula = $_POST['idPelicula'];
if (
    isset($_POST['idPelicula']) && !empty($_POST['idPelicula'])
    && isset($_POST['nombrePelicula']) && !empty($_POST['nombrePelicula'])
    && isset($_POST['descripcionPelicula']) && !empty($_POST['descripcionPelicula'])
    && isset($_POST['checkGenero']) && !empty($_POST['checkGenero'])
    && isset($_POST['checkIdioma']) && !empty($_POST['checkIdioma'])
) {


    $nombrePeli = $_POST['nombrePelicula'];
    $descripcionPeli = $_POST['descripcionPelicula'];

    require_once "../modelo/mysql.php";
    $mysql = new MySql();

    ////////////////////
    //ACTUALIZO LA PELICULA PELICULA//
    ////////////////////
    //Se hace uso del metodo
    $mysql->conectar();
    //Se guarda la respuesta de la consulta en la variable 
    $consulta = $mysql->efectuarConsulta("UPDATE peliculas.peliculas SET nombre_Pelicula = '" . $nombrePeli . "', descripcion_Pelicula = '" . $descripcionPeli . "' WHERE idPelicula=" . $idPelicula);
    //Se desconect de la base de datos
    $mysql->desconectar();
    ////////////////////
    //INSERTO PELICULA//
    ////////////////////
    //--------------------------------------//

    $mysql->conectar();
    //Se guarda la respuesta de la consulta en la variable 
    $consulta = $mysql->efectuarConsulta("DELETE FROM peliculas.generos_has_peliculas WHERE Peliculas_idPelicula=" . $idPelicula);
    //Se desconect de la base de datos
    $mysql->desconectar();




    $mysql->conectar();
    //Se guarda la respuesta de la consulta en la variable 
    $consulta = $mysql->efectuarConsulta("DELETE FROM peliculas.peliculas_has_idiomas WHERE Peliculas_idPelicula=" . $idPelicula);
    //Se desconect de la base de datos
    $mysql->desconectar();



    //--------------------------------------//
    ////////////////////////////
    ////INSERTO LOS GENEROS////
    ////////////////////////////
    $arregloGenero = $_POST['checkGenero'];
    $largoArregloGenero = count($arregloGenero);
    for ($i = 0; $i < $largoArregloGenero; $i++) {
        $mysql->conectar();
        //Se guarda la respuesta de la consulta en la variable 
        $consulta2 = $mysql->efectuarConsulta("INSERT INTO peliculas.generos_has_peliculas (Generos_idGenero,Peliculas_idPelicula) VALUES (" . $arregloGenero[$i] . "," . $idPelicula . ")");
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
        $consulta2 = $mysql->efectuarConsulta("INSERT INTO peliculas.peliculas_has_idiomas (Peliculas_idPelicula,Idiomas_idIdioma) VALUES (" . $idPelicula . "," . $arregloIdioma[$i] . ")");
        //Se desconect de la base de datos
        $mysql->desconectar();
    }
    ////////////////////////////
    ////INSERTO LOS IDIOMAS////
    ////////////////////////////
    //----------------------------------//
    header("Location: ../listarPeliculas.php");
    session_start();
    $_SESSION['mensajeTitu'] = "Actualizacion Realizada";
    $_SESSION['mensaje'] = "La pelicula fue actualizada correctamente correctamente";
} else {
    header("Location: ../editarPeliculas.php?id=" . $idPelicula);
    session_start();
    $_SESSION['errorTitu'] = "Error al Insertar";
    $_SESSION['error'] = "Por favor llene todos los campos antes de enviar la informacion";
}
