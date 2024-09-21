<?php

namespace Models;

require_once "conexionBD.php";
class Contacto extends ConexionBD
{
    //atributos
    //d 	nombres 	apellidos 	correo 	telefono 	celular 	direccion 	imagen 	idUsuario 	
    private $id;
    private $nombres;
    private $apellidos;
    private $correo;
    private $telefono;
    private $celular;
    private $direccion;
    private $imagen;
    private $idUsuario;

    //GETTER Y SETTER
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    public function getNombres()
    {
        return $this->nombres;
    }

    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
        return $this;
    }

    //CRUD
    //Read - get
    public function listar()
    {
        $cadenaSql = "SELECT * FROM Contactos";
        return $this->consultaNormal($cadenaSql);
    }

    //Read - get - byId
    public function listarUno()
    {
        $cadenaSql = "SELECT * FROM Contactos WHERE id = ?";
        return $this->consultaPreparada($cadenaSql, [$this->getId()], "i");
    }

    //Create - post
    public function crear()
    {
        // 	nombres 	apellidos 	correo 	telefono 	celular 	direccion 	imagen 	idUsuario 	
        $cadenaSql = "INSERT INTO Contactos (nombres, apellidos, correo, telefono, celular, direccion, imagen, idUsuario) values (?,?,?,?,?,?,?,?)";
        $valores = [$this->getNombres(), $this->getApellidos(), $this->getCorreo(), $this->getTelefono(), $this->getCelular(), $this->getDireccion(), $this->getImagen(), $this->getIdUsuario()];
        return $this->consultaPreparada($cadenaSql, $valores, "sssssssi");
    }

    //Update - put
    public function editar()
    {
        $cadenaSql = "UPDATE Contactos SET nombres = ?, apellidos = ?, correo = ?, direccion = ? WHERE id = ?";
        $valores = [$this->getNombres(), $this->getApellidos(), $this->getCorreo(), $this->getTelefono(), $this->getCelular(), $this->getDireccion(), $this->getImagen(), $this->getIdUsuario()];
        return $this->consultaPreparada($cadenaSql, $valores, "sssssssi");
    }

    //Delete - delete
    public function eliminar()
    {
        $cadenaSql = "DELETE FROM Contactos WHERE id =?";
        return $this->consultaPreparada($cadenaSql, [$this->getId()], "i");
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of correo
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set the value of correo
     *
     * @return  self
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     *
     * @return  self
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }


    /**
     * Get the value of telefono
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     *
     * @return  self
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of celular
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set the value of celular
     *
     * @return  self
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get the value of imagen
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get the value of idUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     *
     * @return  self
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }
}
