<?php
require_once '../modelo/mysql.php';
$idPelicula = $_GET['id'];
$mysql = new MySql();

//Se hace uso del metodo
$mysql->conectar();

//Se guarda la respuesta de la consulta en la variable 
$consulta = $mysql->efectuarConsulta("UPDATE peliculas.peliculas SET peliculas.peliculas.estado=0 WHERE idPelicula=" . $idPelicula);

//Se desconect de la base de datos
$mysql->desconectar();

header("Location: ../listarPeliculas.php");
session_start();
$_SESSION['mensajeElimi'] = "Pelicula Eliminada";
$_SESSION['mensajeElimi2'] = "La pelicula se elimino Correctamente";
