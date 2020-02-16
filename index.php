<?php

use fw2\{
    model,
    controller,
    helpers
};

namespace fw2;

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'model/dependencias.php';

$archivo = '';
$nombre = '';
$funcion = '';

if (isset($_GET["controller"]) and strlen($_GET["controller"]) > 0) {
    $archivo = 'controller/' . helpers\utils::input_sanitize($_GET["controller"]) . '.controller.php';
    $model = 'model/' . helpers\utils::input_sanitize($_GET["controller"]) . '.model.php';
    $nombre = __NAMESPACE__ . '\\controller\\' . helpers\utils::input_sanitize($_GET["controller"]);

    if (isset($_GET["action"]) and strlen($_GET["action"])) {
        $funcion = helpers\utils::input_sanitize($_GET["action"]);
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

try {
    if (method_exists($nombre, $funcion)) {
        $controller = new $nombre();
        $controller->$funcion();
    } else {
        helpers\utils::registrarDebug(
                helpers\utils::crearEvento("$nombre" . "->" . "$funcion() NOT FOUND", 'index.php', null)
        );

        helpers\utils::volcarDebug();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
