<?php

namespace fw2\helpers;

class utils
{

    static $objDebug = array();

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
        $contador = count(self::getDebug());
        if ($contador > 0) {
            if (\fw2\model\data::$_DEBUG_) {
                echo "<pre style='$css'>";
                echo '<h3>Debug:</h3>';
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
