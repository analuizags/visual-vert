<?php

namespace core\model;

use core\crud\CRUD;
use Exception;

class Unidade extends CRUD {
    
    const TABELA = "instituicao";
    const COL_CODIGO = "codigo";
    const COL_DESCRICAO = "descricao";

    public function listar(){

        $ordem = self::COL_DESCRICAO . " ASC";

        $whereCondicao = "codigo != ? AND codigo != ?";
        $whereValor = [0, 6];

        $retorno = [];

        try {
            
            $retorno = $this->read(self::TABELA, null, $whereCondicao, $whereValor, null, $ordem);

        } catch (Exception $e) {

            echo "Mensagem: " . $e->getMessage() . "\n Local: " . $e->getTraceAsString();

        }

        return $retorno;
    }
}


?>