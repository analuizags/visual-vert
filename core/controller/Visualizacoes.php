<?php

namespace core\controller;

use core\model\Visualizacao;

require_once "../core/crud/CRUD.php";

class Visualizacoes {

    private $codigo = null;
    private $aluno = null;
    private $sexo = null;
    private $anoLetInicio = null;
    private $anoLetConclusao = null;
    private $codCurso = null;
    private $descCurso = null;
    private $codAreaConhecimento = null;
    private $descAreaConhecimento = null;
    private $codInstituicao = null;
    private $descInstituicao = null;
    private $lista_visualizacao = [];

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function __get($atributo) {
        return $this->$atributo;
    }


    /**
     * Listar opções de filtragem
     *
     * Períodos, Gênero, Instituição e Área de Conhecimento
     *  $campos = null, $busca = [], $ordem = null
     * @return array
     */
    public function opcoesFiltro() {
        $visualizacao = new Visualizacao();

        $lista = $visualizacao->listar('filtro', 'anoLetInicio', null, null);
        $this->__set("periodos", $lista);

        $lista = $visualizacao->listar('filtro', 'sexo', null, null);
        $this->__set("generos", $lista);

        $lista = $visualizacao->listar('filtro', 'instituicao', null, null);
        $this->__set("instituicoes", $lista);

        $lista = $visualizacao->listar('filtro', 'areaConhecimento', null, null);
        $this->__set("areas", $lista);

        return [
            "periodos" => $this->periodos,
            "generos" => $this->generos,
            "instituicoes" => $this->instituicoes,
            "areas" => $this->areas
        ];
    }

    public function filtrar($dados) {
        $visualizacao = new Visualizacao();

        // print_r($dados);
        return "Este método está sendo chamado!";
        
        // $lista = $visualizacao->listar('filtro', 'areaConhecimento', null, null);
        // $this->__set("areas", $lista);

        // return [
        //     "periodos" => $this->periodos,
        //     "generos" => $this->generos,
        //     "instituicoes" => $this->instituicoes,
        //     "areas" => $this->areas
        // ];
    }
}
