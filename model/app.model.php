<?php

namespace fw2\model;

class app
{

    private $pdo;
    private $sql;
    private $atributos;

    public function __construct()
    {
        $this->pdo = new \fw2\helpers\db();
        $this->sql = $this->pdo->getPDO();
    }

    public final function llenarDatos($nombre_tabla, int $id)
    {
        try {
            $stm = $this->sql->prepare('CALL ' . data::$_PREFIJOSP_ . $nombre_tabla . '_listar(?)');
            $arr_param = array($id);
            $stm->execute($arr_param);
            $conteo = $stm->rowCount();
            if ($conteo > 0) {
                foreach ($stm->fetchAll(\PDO::FETCH_OBJ) as $value) {
                    $this->atributos = $value;
                    $this->atributos->existe = true;
                }
            } else {
                $this->atributos = new \stdClass();
                $this->atributos->existe = false;
            }
        } catch (Exception $exc) {
            helpers\utils::registrarDebug(
                    helpers\utils::crearEvento("ERROR FILLING DATA ON MAIN MODEL", 'app.model.php', $exc->getTraceAsString())
            );
        }
    }

    protected final function limpiarDatos()
    {
        $this->atributos = null;
    }

    public final function newData(\stdClass $data)
    {
        $this->atributos = $data;
        $this->atributos->existe = false;
    }

    public final function getData($nombre_atributo)
    {
        return isset($this->atributos->$nombre_atributo) ? $this->atributos->$nombre_atributo : null;
    }

}
