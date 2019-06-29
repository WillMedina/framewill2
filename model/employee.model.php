<?php

namespace framewill2\model;

class employee extends app
{

    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        $datos = array();
        $stm = $this->sql->prepare('SELECT * FROM category');
        $stm->execute();
        foreach ($stm->fetchAll(\PDO::FETCH_OBJ) as $data) {
            $datos[] = $data;
        }

        return $datos;
    }

}
