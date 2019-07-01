<?php

namespace fw2\model;

class employee extends app implements modelo
{

    private $tabla_asociada = 'employee';

    public function __construct()
    {
        parent::__construct();
    }

    public function setData(int $id)
    {
        if ($id > 0) {
            $this->limpiarDatos();
            $this->llenarDatos($this->tabla_asociada, $id);
        }
    }

    public function test2()
    {
        return $this->getData('born');
    }

}
