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
    private $listaVisualizacao = [];

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
        
        $campos = " a.codigo AS aluno";
        
        $listaCodigos = $visualizacao->listar('codigos', $campos, $dados, null);
        $dados['aluno'] = array_column($listaCodigos, 'aluno');
        
        $campos = "m.codigo AS codigo,
                    a.codigo AS aluno,
                    a.sexo AS sexo,
                    m.anoLetInicio AS anoLetInicio,
                    m.anoLetConclusao AS anoLetConclusao,
                    m.situacao,
                    c.codigo AS codCurso,
                    c.descricao AS descCurso,
                    ac.codigo AS codAreaConhecimento,
                    ac.descricao AS descAreaConhecimento,
                    i.codigo AS codInstituicao,
                    i.descricao AS descInstituicao";            
        
        $ordem = "a.codigo, m.anoLetInicio, m.anoLetConclusao";

        $lista = $visualizacao->listar(null, $campos, $dados, $ordem);

        // echo "<pre>";            
        // print_r($dados['aluno']);
        // print_r($lista);

        $this->calcularVert($lista, $dados['aluno']);

        // $this->__set("listaVisualizacao", $lista);

        // return $this->listaVisualizacao;
        return "<br>Este método está sendo chamado!";
    } 

    public function calcularVert($dados, $codigos) {

        // echo "<pre>";
        // print_r($codigos);
        // print_r($dados);

        $concluido = [5, 6, 12, 13, 15, 18, 19, 23, 24];
        $matriculado = [0, 14, 16, 21];
        $evadido = [2, 3, 4, 7, 8, 9, 10, 11, 20, 22];

        $alunos = array_column($dados, 'aluno'); // pega a key especifica em cada objeto dentro do array
        
        // foreach ($codigos as $key => $value) {
            
            // $search = $value;
            $search = 3553;
            
            while (!empty($key = array_search($search, $alunos))) {
                $dadosAluno[] = $dados[$key];
                $alunos[$key] = 0;
            } 

            for ($i=0; $i < count($dadosAluno); $i++) { 
                for ($j=$i+1; $j < count($dadosAluno); $j++) { 
                    echo "<br>" . $dadosAluno[$i]->descCurso . " -> " . $dadosAluno[$j]->descCurso;

                    // if ($dadosAluno[$i]->descCurso < $dadosAluno[$j]->descCurso) { // se subir de nível
                        
                    //     if (in_array($dadosAluno[$i]->situacao, $concluido)) {
                            
                    //         if (in_array($dadosAluno[$i]->situacao, $concluido)) {
                    //             # Verticalização Concluída
                    //         } elseif (in_array($dadosAluno[$i]->situacao, $matriculado)) {
                    //             # Verticalização Em Fluxo
                    //         } elseif (in_array($dadosAluno[$i]->situacao, $evadido)) {
                    //             # Verticalização Não Concluída
                    //         }
                            
                    //     } elseif (in_array($dadosAluno[$i]->situacao, $evadido)) {
                            
                    //         if (in_array($dadosAluno[$i]->situacao, $concluido)) {
                    //             # Verticalização Reingresso Concluída
                    //         } elseif (in_array($dadosAluno[$i]->situacao, $matriculado)) {
                    //             # Verticalização Reingresso Em Fluxo
                    //         } elseif (in_array($dadosAluno[$i]->situacao, $evadido)) {
                    //             # Verticalização Reingresso Não Concluída
                    //         }
                            
                    //     }

                    // }

                    /*
                    $grafico = [
                        'eixo' => [
                            'total' => nº,
                            'vertConcluida' => [
                                'total' => nº de alunos verticalizados,
                                'anos' => [
                                    '2015' => [
                                        'total' => nº,
                                        'campus' => [
                                            'ceres' => [
                                                'total' => nº,
                                                'areas' => [
                                                    'exatas' => nº,
                                                    ...
                                                ]
                                            ]
                                        ]
                                    ],
                                    ...
                                ]
                            ]
                        ]
                    ]
                    */

                }
            }
        
        // }        

        return "<br>Calculado!";
    }
}
