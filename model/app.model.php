<?php

namespace fw2\model;

class app
{

    private $pdo;
    private $sql;
    private $atributos;

    public function __construct()
    {
        $this->pdo = new \fw2\helpers\db();
        $this->sql = $this->pdo->getPDO();
        $this->atributos = new \stdClass();
        setlocale(LC_TIME, "es_ES");
    }

    public final function llenarDatos($nombre_tabla, int $id, $nombresp = null)
    {
        try {
            //debe existir un estore procedure llamado "listar[nombre tabla]s()"

            $sp = (is_null($nombresp) ? 'listar' . $nombre_tabla . 's(?)' : $nombresp . '(?)');
            $sql = 'CALL ' . data::$_PREFIJOSP_ . $sp;
            $stm = $this->sql->prepare($sql);
            $arr_param = array($id);
            $stm->execute($arr_param);
            $conteo = $stm->rowCount();
            if ($conteo > 0) {
                foreach ($stm->fetchAll(\PDO::FETCH_OBJ) as $value) {
                    $this->atributos = $value;
                    $this->atributos->existe = true;
                }
            } else {
                $this->atributos = new \stdClass();
                $this->atributos->existe = false;
            }

            //$this->atributos->sql = $sql;
        } catch (\Throwable $e) {
            \fw2\helpers\debugger::reportar('Error en la obtencion de datos', 'app.model.php', $e->getTraceAsString(), $e);
            \fw2\helpers\debugger::volcar();
        }
    }

    public function render_pagina($template, $cambios = null, $en_variable = false)
    {
        $root = \fw2\model\data::$_ROOT_;

        $salida = new \fw2\helpers\output($root . 'view/' . $template . '.template.html');
        $header = new \fw2\helpers\output($root . 'view/layout/header.html');
        $head = new \fw2\helpers\output($root . 'view/layout/head.html');
        $sidebar = new \fw2\helpers\output($root . 'view/layout/sidebar.html');
        $footer = new \fw2\helpers\output($root . 'view/layout/footer.html');

        $head->cambiar('{CSS}', \fw2\model\data::$_URL_ . '/' . \fw2\model\data::$_HTMLCSS_);

        $footer->cambiar('{JQUERY}', \fw2\model\data::$_URL_ . '/' . \fw2\model\data::$_JSJQUERY_);

        //fix para cuando no hay funciones
        if (!isset($cambios['{FUNCIONES}'])) {
            $footer->cambiar('{FUNCIONES}', \fw2\model\data::$_URL_ . '/static/js/' . $template . '.funciones.js');
        }

        if (!isset($cambios['{ESTILO}'])) {
            $head->cambiar('{ESTILO}', \fw2\model\data::$_URL_ . '/static/css/' . $template . '.estilos.css');
        }

        $salida->cambiar('{HEAD}', $head->print(true));
        $salida->cambiar('{SIDEBAR}', $sidebar->print(true));
        $salida->cambiar('{HEADER}', $header->print(true));
        $salida->cambiar('{FOOTER}', $footer->print(true));
        $salida->cambiar('{YEAR}', date('Y'));
        $salida->cambiar('{VERSION}', \fw2\model\data::$_VERSION_);

        $salida->cambiar('{URL}', \fw2\model\data::$_URL_);
        $salida->cambiar('{TITULO}', \fw2\model\data::$_APLICACION_);

        //Aqui es donde se hacen los cambios que puedan sobreescribir los de arriba
        if (!is_null($cambios) and is_array($cambios)) {
            //var_dump($cambios);
            foreach ($cambios as $key => $value) {
                $salida->cambiar($key, $value);
            }
        }

        if ($en_variable) {
            return $salida->print(true);
        } else {
            $salida->print();
        }
    }

    /*
     * store_procedure
     * Funcion maestra por la que pasan todas las consultas a BD
     * Ubicacion: app.model.php
     *       
     */

    public function store_procedure($nombre_sp, Array $parametros = null)
    {
        try {
            $contador_array = (is_null($parametros)) ? 0 : count($parametros);
            $array_signos = [];
            $signos = '';
            $salida = array();

            for ($i = 0; $i < $contador_array; $i++) {
                $array_signos[] = '?';
            }

            if (count($array_signos) > 0) {
                $signos = implode(',', $array_signos);
            }

            $stm = $this->sql->prepare('CALL ' . data::$_PREFIJOSP_ . $nombre_sp . "($signos)");
            //$stm->execute((($contador_array == 0) ? null : $parametros));
            $stm->execute($parametros);

            foreach ($stm->fetchAll(\PDO::FETCH_OBJ) as $value) {
                $salida[] = $value;
            }

            return $salida;
        } catch (\Throwable $e) {
            \fw2\helpers\debugger::reportar('Warning: excepcion interna con el manejo de store procedures',
                    'app.model.php', $e->getTraceAsString(), $e);
            \fw2\helpers\debugger::volcar();
            return $e;
        }
    }

    protected final function limpiarDatos()
    {
        $this->atributos = null;
    }

    public final function newData(\stdClass $data)
    {
        $this->atributos = $data;
        $this->atributos->existe = false;
    }

    public final function getData($nombre_atributo)
    {
        return isset($this->atributos->$nombre_atributo) ? $this->atributos->$nombre_atributo : null;
    }

}
