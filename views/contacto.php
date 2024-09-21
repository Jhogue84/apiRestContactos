<?php
header('Access-Control-Allow-Origin: *');

use Controllers\contactoController;

require_once("../controllers/contactoController.php");

$contactoController = new contactoController();

$verbo = $_SERVER["REQUEST_METHOD"];
switch ($verbo) {
    case 'GET':
        //$contactoController->inicio();
        //var_dump($contactoController->getRutaImagen());
        $json = isset($_GET['id']) ? $contactoController->ver($_GET['id']) : $contactoController->inicio();
        echo $json;
        break;
    case 'POST':
        $json = $contactoController->insertar();
        echo $json;
        break;
    case 'PUT':
        $json = $contactoController->editar($_GET['id']);
        echo $json;
        break;
    case 'DELETE':
        $json = $contactoController->eliminar($_GET['id']);
        echo $json;
        break;

    default:
        echo "no hay metodo seleccionado";
        break;
}
