<?php
class usuarios
{
    private $id;
    private $usuario;
    


    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    //DEVOLVER DATOS

    public function getId()
    {
        return $this->id;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
}
