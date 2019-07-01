<?php

namespace fw2\helpers;

class db
{

    public $objCon = null;

    public function __construct()
    {
        try {
            date_default_timezone_set(\fw2\model\data::$_TIMEZONE_);
            $this->objCon = new \PDO(\fw2\model\data::DSN(), \fw2\model\data::$_USUARIO_, \fw2\model\data::$_PASSWORD_);
        } catch (PDOException $e) {
            $evento = utils::crearEvento($e->getMessage(), 'db.helper.php', $e->getTraceAsString());
            utils::registrarDebug($evento);
            utils::volcarDebug(); //se llama aqui porque el sistema no deberia hacer nada mas al no conectar
        }
    }

    public final function getPDO()
    {
        return $this->objCon;
    }

    public static function PDO()
    {
        return $this->objCon;
    }

}
