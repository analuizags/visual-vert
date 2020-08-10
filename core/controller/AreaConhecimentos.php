<?php

namespace core\controller;

require_once "../core/crud/CRUD.php";

use core\model\AreaConhecimento;

class AreaConhecimentos {
    
    private $codigo = null;
    private $descricao = null;
    private $listaAreas = null;
    
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function __get($atributo){
        return $this->$atributo;
    }

    
    public function listarAreas(){
        $areaConhecimento = new AreaConhecimento();

        $lista = $areaConhecimento->listar();

        if (count($lista) > 0) {
            $this->__set("listaAreas", $lista);
        }

        return $this->listaAreas;
    }
}


?>