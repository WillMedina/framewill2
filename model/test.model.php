<?php

/**
 * Este archivo aunque no es necesario, suelo usarlo para aplicar 
 * testeos de datos fuera de la aplicacion, reservando ademas la palabra 
 * "test" en los URL y dejandola inutilizable en produccion, util para
 * temas de pentesting.
 */
namespace fw2\model;

class test extends app implements modelo
{

    private $tabla_asociada = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function setData(int $id)
    {
        return $id;
    }

    public function test()
    {
        /* Aqui se pueden probar funcionalidades tecnicas via test */
        $parametros = [''];
        $servicios = $this->store_procedure('', $parametros);
        return $servicios;
    }

}
