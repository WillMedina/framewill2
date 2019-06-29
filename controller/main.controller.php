<?php

namespace framewill2\controller;

class main
{

    public function __construct()
    {
        
    }

    public function run()
    {
        $root = \framewill2\model\data::$_ROOT_;
        echo \framewill2\helpers\utils::output_html($root . '/view/html/login.template.html');
    }

}
