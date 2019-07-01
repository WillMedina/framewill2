<?php

namespace fw2\model;

class data
{

    static $_SERVIDOR_ = 'localhost';
    static $_USUARIO_ = 'root';
    static $_BD_ = 'enterprise';
    static $_PASSWORD_ = '';
    static $_VERSION_ = '20190629.0252';
    static $_TIMEZONE_ = 'America/Lima';
    static $_DEBUG_ = true;
    static $_ROOT_ = __DIR__ . '/../';
    static $_PREFIJOSP_ = 'fw2_';
    static $_COMPRESSHTML_ = true;

    public static function DSN()
    {
        return 'mysql:host=' . self::$_SERVIDOR_ . ';dbname=' . self::$_BD_;
    }

}
