<?php

namespace fw2;

use fw2\{
    model,
    controller,
    helpers
};

session_start();

//ini_set('display_errors', 0);
//ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);

require_once 'model/dependencias.php';

$archivo = '';
$nombre = '';
$funcion = '';

try {
    $get_controller = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING) ?? 'main';
    $get_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? 'run';

    if (strlen($get_controller) > 0) {
        $archivo = 'controller/' . \fw2\helpers\utils::input_sanitize($get_controller) . '.controller.php';
        $model = 'model/' . \fw2\helpers\utils::input_sanitize($get_controller) . '.model.php';
        $nombre = __NAMESPACE__ . '\\controller\\' . \fw2\helpers\utils::input_sanitize($get_controller);

        if (strlen($get_action) > 0) {
            $funcion = \fw2\helpers\utils::input_sanitize($get_action);
        } else {
            $funcion = 'run';
        }
    } else {
        $nombre = __NAMESPACE__ . '\\controller\\main';
        $funcion = 'run';
    }

    if (file_exists($archivo) and $archivo != 'controller/main.controller.php') {
        require $archivo;
        require $model;
    }


    if (method_exists($nombre, $funcion)) {
        $controller = new $nombre();
        $controller->$funcion();
    } else {
        \fw2\helpers\debugger::reportar('No existe el m&eacute;todo ' . $funcion, 'index.php');
        \fw2\helpers\debugger::volcar(true);
    }
} catch (\Throwable $e) {
    //echo $e->getMessage();
    \fw2\helpers\debugger::reportar('Error interno desconocido', 'index.php', $e->getTraceAsString(), $e);
    \fw2\helpers\debugger::volcar(true);
}
