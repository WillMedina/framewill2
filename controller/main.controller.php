<?php

namespace fw2\controller;

class main implements controlador
{

    public $obj;

    public function __construct()
    {
        $this->obj = new \fw2\model\app();
    }

    public function run()
    {
        $app = new \fw2\model\app();
//        if ($app->verificar_logueo()) {
        $cambios = [];
        $app->render_pagina('home', $cambios);
//        } else {
//            $app->render_login();
//        }
    }

}
