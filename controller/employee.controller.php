<?php

/* Este archivo es un archivo ejemplo de controlador, no forma parte
 * de los archivos base del framework y puede ser borrado
 * si asi lo requiere la personalizacion del proyecto, de la misma
 * forma puede ser tomado como ejemplo de aprendizaje
 */

namespace fw2\controller;

class employee extends main implements controlador
{

    public $obj;

    public function __construct()
    {
        parent::__construct();
        $this->obj = new \fw2\model\employee();
    }

    public function run()
    {
        
    }

    public function test()
    {
        echo '<pre style="font-size: 15px; font-weight: 900">';
        
        $this->obj->setData(1);
        
        var_dump($this->obj->getData('existe'));
        //\fw2\helpers\debugger::volcar();
        echo '</pre>';
    }

}
