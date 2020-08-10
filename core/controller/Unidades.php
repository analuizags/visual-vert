<?php

namespace core\controller;

require_once "../core/crud/CRUD.php";

use core\model\Unidade;

class Unidades {
    
    private $codigo = null;
    private $descricao = null;
    private $listaUnidades = null;
    
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function __get($atributo){
        return $this->$atributo;
    }

    
    public function listarUnidades(){
        $unidade = new Unidade();

        $lista = $unidade->listar();

        if (count($lista) > 0) {
            $this->__set("listaUnidades", $lista);
        }

        return $this->listaUnidades;
    }
}


?>