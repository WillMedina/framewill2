<?php

use framewill2\{
    model,
    helpers
};

//namespace framewill2\model;

class conector
{

    private $objCon = null;

    public function __construct()
    {
        try {
            date_default_timezone_set(model\data::$_TIMEZONE_);
            $this->objCon = new PDO(model\data::DSN(), model\data::$_USUARIO_, model\data::$_PASSWORD_);
        } catch (PDOException $e) {
            $evento = helpers\utils::crearEvento($e->getMessage(), 'conector.__construct()', $e->getTraceAsString());
            helpers\utils::registrarDebug($evento);
            helpers\utils::volcarDebug(); //se llama aqui porque el sistema no deberia hacer nada mas al no conectar
        }
    }

    public function getPDO()
    {
        return $this->objCon;
    }

}
