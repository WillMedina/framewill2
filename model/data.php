<?php

namespace fw2\model;

class data
{

    static $_SERVIDOR_ = 'localhost';
    static $_USUARIO_ = 'root';
    static $_BD_ = 'enterprise';
    static $_PASSWORD_ = '';
    static $_VERSION_ = '20210610.1844';
    static $_TIMEZONE_ = 'America/Lima';
    static $_DEBUG_ = true;
    static $_ROOT_ = __DIR__ . '/../';
    static $_PREFIJOSP_ = '';
    static $_COMPRESSHTML_ = true;
    static $_URL_ = 'http://localhost/weblocal/framewill2';
    static $_APLICACION_ = '';
    //
    //Rutas estaticas relativas a la raiz, cambiar donde haga falta
    //o reemplazar donde requiera en la variable $cambios
    //por default quedan estas pero puede ir en blanco tambien
    //ToDo: Mejorar reconocimiento de nulos en estas variables 

    static $_HTMLCSS_ = 'static/css/extra.style.css';
    static $_JSJQUERY_ = 'static/jquery.js';

    public static function DSN()
    {
        return 'mysql:host=' . self::$_SERVIDOR_ . ';dbname=' . self::$_BD_;
    }

}
