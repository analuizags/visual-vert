<?php

namespace core\controller;

require_once "../core/controller/Visualizacoes.php";    
require_once "../core/model/Visualizacao.php";

use core\sistema\Requisicao;

class Api {

    public function init() {

        $requisicao = new Requisicao();
        $request = $requisicao->get(true);

        $dados = $request['dados'];
        $acao = $request['acao'];

        $api_controller = explode('/', $acao);

        $classe = "\\core\\controller\\" . $api_controller[0];
        $metodo = $api_controller[1];

        $class = new $classe();

        if (method_exists($class, $metodo)) {
            echo call_user_func_array([$class, $metodo], [$dados, $this]);
        } else {
            echo "Ação não encontrada";
        }
    }
}
