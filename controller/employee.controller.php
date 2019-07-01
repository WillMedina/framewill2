<?php

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
        echo '<pre>';
        print_r($this->obj);
        echo '</pre>';
    }

}
