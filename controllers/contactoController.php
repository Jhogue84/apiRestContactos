<?php

namespace Controllers;

use Models\Contacto;

require_once "../models/contactos.php";

class ContactoController
{
    private $modeloContacto;
    private $rutaImagen;
    public function __construct()
    {
        $this->modeloContacto = new Contacto();
        $this->rutaImagen = dirname(__DIR__) . "\images\\";
    }

    public function getRutaImagen()
    {
        $ruta = explode("htdocs", $this->rutaImagen)[1];
        $ruta = str_replace("\\", "/", $ruta);
        return $ruta;
    }
    public function inicio()
    {
        $contactos = $this->modeloContacto->listar();
        //AGREGAR LA RUTA A LAS IMAGENES
        for ($i = 0; $i < count($contactos); $i++) {
            if ($contactos[$i]["imagen"] !== null && $contactos[$i]["imagen"] !== "") {
                //C:/xampp/htdocs/apirest/
                $contactos[$i]["imagen"] = "http://" . $_SERVER["HTTP_HOST"] .  $this->getRutaImagen() . $contactos[$i]["imagen"];
                //$Contactos[$i]["nomImagen"] = $this->rutaImagen . $Contactos[$i]["nomImagen"];
            }
        }

        if ($contactos) return json_encode($contactos);
        else return json_encode(["mensaje" => "No hay registros para mostrar"]);
    }

    public function ver($id)
    {
        $this->modeloContacto->setId($id);
        $producto = $this->modeloContacto->listarUno();
        if ($producto) return json_encode($producto);
        else return json_encode(["mensaje" => "No existe el producto con id: {$id}"]);
    }

    //insertar
    public function insertar()
    {
        $json = file_get_contents("php://input");
        $_POST = json_decode($json, true);
        //nombres 	apellidos 	correo 	telefono 	celular 	direccion 	imagen 	idUsuario 	
        $this->modeloContacto->setNombres($_POST["nombres"]);
        $this->modeloContacto->setApellidos($_POST["apellidos"]);
        $this->modeloContacto->setCorreo($_POST["correo"]); //
        $this->modeloContacto->setTelefono($_POST["telefono"]);
        $this->modeloContacto->setCelular($_POST["celular"]);
        $this->modeloContacto->setDireccion($_POST["direccion"]);
        //verificar imagen
        if (isset($_POST["imagen"]) || $_POST["imagen"] !== null) {
            $imagen64oArray = $this->validarImagen($_POST["imagen"]);
            $this->modeloContacto->setImagen($imagen64oArray["nomImagen"]); //
        } else {
            $imagen64oArray = ["mensajeImg" => ""];
            $this->modeloContacto->setImagen(null); //
        }
        $this->modeloContacto->setIdUsuario($_POST["idUsuario"]);
        $this->modeloContacto->crear();
        return json_encode(["mensaje" => "Correcto !!! Nuevo producto almacenado. {$imagen64oArray['mensajeImg']}"]);
    }

    public function editar($id)
    {
        $this->modeloContacto->setId($id);
        $json = file_get_contents("php://input");
        $_POST = json_decode($json, true);
        //nombres 	apellidos 	correo 	telefono 	celular 	direccion 	imagen 	idUsuario 	
        $this->modeloContacto->setNombres($_POST["nombres"]);
        $this->modeloContacto->setApellidos($_POST["apellidos"]);
        $this->modeloContacto->setCorreo($_POST["correo"]); //
        $this->modeloContacto->setTelefono($_POST["telefono"]);
        $this->modeloContacto->setCelular($_POST["celular"]);
        $this->modeloContacto->setDireccion($_POST["direccion"]);
        //verificar imagen
        if (isset($_POST["imagen"]) || $_POST["imagen"] !== null) {
            $imagen64oArray = $this->validarImagen($_POST["imagen"]);
            $this->modeloContacto->setImagen($imagen64oArray["nomImagen"]); //
        } else {
            $imagen64oArray = ["mensajeImg" => ""];
            $this->modeloContacto->setImagen(null); //
        }
        $this->modeloContacto->setIdUsuario($_POST["idUsuario"]);
        ///
        $rta = $this->modeloContacto->editar();
        if (!$rta) {
            return json_encode(["mensaje" => "Correcto !!! editado producto con id: {$id}"]);
        } else {
            return json_encode(["mensaje" => "Incorrecto !!! el producto con id: {$id} no existe."]);
        }
    }

    public function eliminar($id)
    {
        if ($this->ver($id)) {
            $this->modeloContacto->setId($id);
            $rta = $this->modeloContacto->eliminar();
            return (!$rta) ? json_encode(["mensaje" => "Producto, Eliminado"]) : json_encode(["mensaje" => "Producto, error al eliminar"]);
        } else {
            return json_encode(["mensaje" => "No existe ese producto para eliminar"]);
        }
    }

    public function validarImagen($imagen)
    {
        //data:image/jpeg;base64,/9j/4AAQSkZJRgABAQ.....
        $imgBase64 = explode(";base64,", $imagen)[1];
        $extencion = explode(";", $imagen)[0];
        $extencion = explode("/", $extencion)[1];
        //subir imagen al servidor
        $fecha = Date("Ymd-Hms");
        $nomImagen = $fecha . "." . $extencion;
        $imagen = $this->rutaImagen . $nomImagen;
        $imgBase64 = base64_decode($imgBase64);
        file_put_contents($imagen, $imgBase64);
        $mensaje = "Imagen cargada en el servidor.";
        $imagenArray = ["mensajeImg" => $mensaje, "nomImagen" => $nomImagen];
        return $imagenArray;
    }
}
