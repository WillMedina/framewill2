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
        } catch (\Throwable $e) {
            debugger::reportar('Error en la conexi&oacute;n de base de datos', 'db.helper.php', $e->getTraceAsString(), $e);
            debugger::volcar(true);
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
