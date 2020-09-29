<?php

/* Este archivo es un archivo ejemplo de modelo, no forma parte
 * de los archivos base del framework y puede ser borrado
 * si asi lo requiere la personalizacion del proyecto, de la misma
 * forma puede ser tomado como ejemplo
 */

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
