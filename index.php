<?php
require_once "models/Cliente.php";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode(Cliente::getWhere($_GET['id']));
        } // end if
        else {
            echo json_encode(Cliente::getAll());
        } //end else
        break;

    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {
            if (Cliente::insert($datos->nombre, $datos->ap, $datos->am, $datos->fn, $datos->genero)) {
                http_response_code(200);
            } //end if
            else {
                http_response_code(400);
            } //end else
        } //end if
        else {
            http_response_code(405);
        } // end else
        break;

    case 'PUT':

        $datos = Cliente::getWhere($_GET['id']);
        $datos = json_decode(json_encode($datos), true);

        $id_update = $datos[0]['id'];

        $datos_update = json_decode(file_get_contents('php://input'));

        if ($datos != NULL) {
            if (Cliente::update($id_update, $datos_update->nombre, $datos_update->ap, $datos_update->am, $datos_update->fn, $datos_update->genero)) {
                http_response_code(200);
            } //end if
            else {
                http_response_code(400);
            } //end else
        } //end if
        else {
            http_response_code(405);
        } // end else
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            if (Cliente::delete($_GET['id'])) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        } else {
            http_response_code(405);
        }
        break;

    default:
        http_response_code(405);
        break;
}
