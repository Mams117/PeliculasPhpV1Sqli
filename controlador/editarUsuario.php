<?php

require_once '../modelo/MySQL.php';


//capturo los datos obtenidos en variables

$usuario = $_POST["usuarioEditar"];
$password = md5($_POST["contraseñaEditar"]);
$id = $_POST["id"];

//instanciamos la clase,se llama para usar

$mySql = new MySQL();

//se hace uso del metodo para conectarse a la base de datos

$mySql->conectar();


//se guarda en una variable la consulta utilizando el metodo para dicho proceso


$usuario = $mySql->efectuarConsulta("UPDATE peliculas.usuarios SET peliculas.usuarios.usuario ='" . $usuario . "',peliculas.usuarios.contraseña='" . $password . "'WHERE peliculas.usuarios.id=" . $id);
