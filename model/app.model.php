<?php

namespace framewill2\model;

class app
{

    public $pdo;
    public $sql;

    public function __construct()
    {
        $this->pdo = new \conector();
        $this->sql = $this->pdo->getPDO();
    }

}
