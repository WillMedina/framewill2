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
        $cambios = [];
        $app->render_pagina('welcome', $cambios);
    }

}
