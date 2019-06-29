<?php

namespace framewill2\helpers;

class utils
{

    // Esto resuelve el problema del OPENSSL
    // https://jorgearce.es/index.php/post/2017/08/07/file_get_contents%28%29%3A-Failed-to-enable-crypto
    // https://stackoverflow.com/questions/26148701/file-get-contents-ssl-operation-failed-with-code-1-and-more
    static $arrContextOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );
    static $objDebug = array();

    static function output_html($stream, $array_cambios = null)
    {
        $archivo = file_get_contents($stream, false, stream_context_create(self::$arrContextOptions));
        if (!is_null($array_cambios)) {
            //$archivo = file_get_contents($stream, false, stream_context_create(self::$arrContextOptions));
            $indices = array_keys($array_cambios);
            $valores = array_values($array_cambios);
            $archivo = str_replace($indices, $valores, $archivo);
        }
        return $archivo;
    }

    static function input_sanitize($string)
    {
        $array_danger = array("'", '"', '\u2019', '%', '&#8217;');
        $string = str_replace($array_danger, "", $string);
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }

    static function sanitize_output($buffer)
    {

        $search = array(
            '/\>[^\S ]+/s', // strip whitespaces after tags, except space
            '/[^\S ]+\</s', // strip whitespaces before tags, except space
            '/(\s)+/s', // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $buffer_output = preg_replace($search, $replace, $buffer);
        return $buffer_output;
    }

    static function time_UnixToMySQL($unixtime)
    {
        $mysql_time = date('Y-m-d H:i:s', $unixtime);
        return $mysql_time;
    }

    static function time_MySQLToUnix($mysqltime)
    {
        $timestamp = strtotime($mysqltime);
        return $timestamp;
    }

    static function formatTime($mysqltime, $format = "d-m-Y g:i A")
    {
        $time = strtotime($mysqltime);
        $myFormatForView = date($format, $time);
        return $myFormatForView;
    }

    static function v_dump($variable, $json = false)
    {
        $salida = null;
        ob_start();
        var_dump($variable);
        $result = ob_get_clean();

        if (!$json) {
            $salida = '<pre>' . $result . '</pre>';
        } else {
            $salida = str_replace('"', '\"', $result);
        }

        return $salida;
    }

    static function crearEvento($mensaje, $donde, $traza)
    {
        $evento = new \stdClass();
        $evento->timestamp = new \DateTime();
        $evento->mensaje = $mensaje;
        $evento->donde = $donde;
        $evento->traza = $traza;
        return $evento;
    }

    public static function volcarDebug()
    {
        $css = 'font-family: verdana; font-size: 14px; padding: 1%';

        if (\framewill2\model\data::$_DEBUG_) {
            echo "<pre style='$css'>";
            echo '<h2>Debug:</h2>';
            foreach (self::getDebug() as $debug) {
                echo '<b>TIME:</b> ' . $debug->timestamp->format('d-m-Y H:i:s') . "<br />";
                echo '<b>MENSAJE:</b> ' . $debug->mensaje . "<br />";
                echo '<b>DONDE:</b> ' . $debug->donde . "<br />";
                echo '<b>TRAZA:</b><br />' . $debug->traza . "<br />";
                echo '<br /><hr />';
            }
            echo '</pre>';
            die();
        } else {
            echo "<h2 style='$css'>Ha ocurrido un error interno</h2>";
            die();
        }
    }

    public static function registrarDebug(\stdClass $evento)
    {
        array_push(self::$objDebug, $evento);
    }

    public static function getDebug()
    {
        return self::$objDebug;
    }

}
