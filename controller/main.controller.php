<?php

namespace fw2\controller;

class main implements controlador
{

    protected $bootstrapjs = '';
    protected $bootstrapcss = '';
    protected $jquery = '';

    public function __construct()
    {
        $this->jquery = '';
        $this->bootstrapjs = '';
        $this->bootstrapcss = '';
    }

    public function run()
    {
        $root = \fw2\model\data::$_ROOT_;

        $salida = new \fw2\helpers\output($root . 'view/welcome.template.html');
        $head = new \fw2\helpers\output($root . 'view/layout/head.html');
        $footer = new \fw2\helpers\output($root . 'view/layout/footer.html');

        $head->cambiar('{BOOTSTRAPCSS}', 'static/bootstrap.css');
        $head->cambiar('{EXTRACSS}', 'static/css/extra.style.css');

        $footer->cambiar('{BOOTSTRAPJS}', 'static/bootstrap.js');
        $footer->cambiar('{FUNCIONES}', 'static/js/main.funciones.js');

        $salida->cambiar('{HEAD}', $head->print(true));
        $salida->cambiar('{FOOTER}', $footer->print(true));

        $salida->print();
    }

}
