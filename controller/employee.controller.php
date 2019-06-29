<?php

namespace framewill2\controller;

class employee extends main
{

    public $obj;

    public function __construct()
    {
        parent::__construct();
        $this->obj = new \framewill2\model\employee();
    }

    public function run()
    {
        
    }

    public function test()
    {
        echo '<pre>';
        var_dump($this->obj->test());
        echo '</pre>';
    }

}
