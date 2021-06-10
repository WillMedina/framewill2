<?php

namespace fw2\helpers;

class debugger
{

    static $objDebug = array();

    static function reportar($mensaje, $donde, $traza = null, $e = null)
    {
        $error = new \stdClass();
        $error->timestamp = (new \Datetime());
        $error->mensaje = $mensaje;
        $error->donde = $donde;
        $error->traza = $traza;
        $error->throwable = $e;

        self::$objDebug[] = $error;
    }

    static function reporte()
    {
        return self::$objDebug;
    }

    static function volcar($fullcrash = false)
    {
        $url = \fw2\model\data::$_URL_ . '/static/css/error.style.css';
        echo '<link href="' . $url . '" rel="stylesheet" />';
        echo '<div class="crash">';
        if (\fw2\model\data::$_DEBUG_) {
            foreach (self::$objDebug as $error) {
                //var_dump($error);
                echo '<div class="error">';
                echo '<h2>' . $error->mensaje . '<h2>';
                echo '<p>Producido en <u>' . $error->donde . '</u> @ ' . $error->timestamp->format('j-M-Y H:i:s') . '</p>';

                if (!is_null($error->traza)) {
                    echo '<pre>' . $error->traza . '</pre>';
                }

                if (!is_null($error->throwable)) {
                    echo '<pre>Mensaje en la excepci&oacute;n: ' . $error->throwable->getMessage() . '<br />'
                    . 'Archivo: ' . $error->throwable->getFile() . '<br />'
                    . 'L&iacute;nea: ' . $error->throwable->getLine() . '<br />'
                    . 'C&oacute;digo: ' . $error->throwable->getCode() . '<br />'
                    . '</pre>';
                }

                echo '</div>';
            }
            //print_r(self::$objDebug);
        } else {
            echo '<p class="centro">Se ha producido un error interno en el sistema, consulte con un administrador</p>';
        }

        echo '<div>';

        if ($fullcrash) {
            die();
        }
    }

}
