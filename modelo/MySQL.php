<?php


//creo la clase conexiones

class MySQL
{

    //datos de validacion

    private $ipServidor = "localhost";
    private $usuarioBase = "root";
    private $password = "";


    private $conexion;


    //Metodo para conectar a la base de datos

    public function conectar()
    {

        $this->conexion = mysqli_connect($this->ipServidor, $this->usuarioBase, $this->password);
    }

    public function desconectar()
    {
        mysqli_close($this->conexion);
    }

    //metodo que efectua una consulta devuelve su resulado

    public function efectuarConsulta($consulta)
    {

        mysqli_query($this->conexion, "SET lc_time_names='es_ES'");

        //atrae el uso de caracteres especiales como tildes con el formato utf8
        mysqli_query($this->conexion, "SET NAMES 'utf8'");

        $this->resultadoConsulta = mysqli_query($this->conexion, $consulta);

        return $this->resultadoConsulta;
    }
}
