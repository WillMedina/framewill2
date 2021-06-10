<?php

namespace fw2\helpers;

class utils
{

    static function crearhash(string $text)
    {
        return password_hash($text, PASSWORD_BCRYPT);
    }

    static function verificarHash(string $password, string $hash)
    {
        return password_verify($password, $hash);
    }

    static function input_url_names($string)
    {
        
    }

    static function input_sanitize($string)
    {
        if (strlen($string > 0)) {
            $array_danger = array("'", '"', '\u2019', '\u2018', '%', '&#8217;','&#8216;');
            $string = str_replace($array_danger, "", $string);
            $string = filter_var($string, FILTER_SANITIZE_STRING);
        }
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

    public static function mes($numero)
    {
        $salida = '';
        switch ($numero) {
            case 1:
                $salida = 'enero';
                break;
            case 2:
                $salida = 'febrero';
                break;
            case 3:
                $salida = 'marzo';
                break;
            case 4:
                $salida = 'abril';
                break;
            case 5:
                $salida = 'mayo';
                break;
            case 6:
                $salida = 'junio';
                break;
            case 7:
                $salida = 'julio';
                break;
            case 8:
                $salida = 'agosto';
                break;
            case 9:
                $salida = 'setiembre';
                break;
            case 10:
                $salida = 'octubre';
                break;
            case 11:
                $salida = 'noviembre';
                break;
            case 12:
                $salida = 'diciembre';
                break;
            default:
                break;
        }

        return $salida;
    }

}
