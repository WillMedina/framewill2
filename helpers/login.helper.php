<?php

namespace fw2\helpers;

class login
{

    static function verificarHash(\string $hash, \string $password)
    {
        return password_verify($password, $hash);
    }

    static function logout()
    {
        session_start();
        session_destroy();
        header('Location: index.php'); //comprobar si redirige bien
    }

}
