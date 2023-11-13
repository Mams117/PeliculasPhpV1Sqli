<?php
require_once '../modelo/MySQL.php';


if (
    isset($_POST["generosRegistro"]) && !empty($_POST["generosRegistro"]) 
    
)


    //capturo los datos obtenidos en variables

    $generosRegistro = $_POST["generosRegistro"];


//instanciamos la clase,se llama para usar

$mySql = new MySQL();

//se hace uso del metodo para conectarse a la base de datos

$mySql->conectar();


//se guarda en una variable la consulta utilizando el metodo para dicho proceso

$usuario = $mySql->efectuarConsulta("INSERT INTO peliculas.generos (peliculas.generos.genero) VALUES ('" . $generosRegistro"')");

//desconecto de la base de datos para liberar memoria

$mySql->desconectar();


//si la consulta arroja 1 fila y es mayor a 0 es que existe un usuario
header("Location:../html/editarUsuario.php");