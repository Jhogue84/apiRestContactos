<?php

namespace Models;

use PDO;
use PDOException;
use PDOStatement;

class ConexionBD
{

    private $conexion;
    public function __construct()
    {
        try {
            $this->conexion = new PDO("mysql:host=localhost; dbname=bdcontactos", "root", "");
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error al conectarse a la base de datos " . $e->getMessage();
        }
    }

    public function consultaNormal($cadenaSql)
    {
        return $this->conexion->query($cadenaSql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultaPreparada($cadenaSql, $values = [], $tipoValues = null,)
    {

        $rta = $this->conexion->prepare($cadenaSql);
        for ($i = 0; $i < count($values); $i++) {
            $rta->bindParam($i + 1, $values[$i]);
        }
        $rta->execute();
        return $rta->fetchAll(PDO::FETCH_ASSOC);
    }
}
