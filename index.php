<?php

use framewill2\{
    model,
    controller,
    helpers
};

namespace framewill2;

include 'model/data.php';
include 'model/conector.php';
include 'helpers/utils.helper.php';
include 'controller/main.controller.php';
include 'model/app.model.php';

$archivo = '';
$nombre = '';
$funcion = '';

if (isset($_GET["controller"]) and strlen($_GET["controller"]) > 0) {
    if (isset($_GET["action"]) and strlen($_GET["action"])) {
        $archivo = 'controller/' . helpers\utils::input_sanitize($_GET["controller"]) . '.controller.php';
        $model = 'model/' . helpers\utils::input_sanitize($_GET["controller"]) . '.model.php';
        $nombre = __NAMESPACE__ . '\\controller\\' . helpers\utils::input_sanitize($_GET["controller"]);
        $funcion = helpers\utils::input_sanitize($_GET["action"]);
    } else {
        $archivo = 'controller/' . helpers\utils::input_sanitize($_GET["controller"]) . '.controller.php';
        $model = 'model/' . helpers\utils::input_sanitize($_GET["controller"]) . '.model.php';
        $nombre = __NAMESPACE__ . '\\controller\\' . helpers\utils::input_sanitize($_GET["controller"]);
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
