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
        
        $campos = "
                    a.codigo AS aluno,
                    a.sexo AS sexo,
                    m.anoLetInicio AS anoLetInicio,
                    m.anoLetConclusao AS anoLetConclusao,
                    m.situacao,
                    c.codigo AS codCurso,
                    c.descricao AS descCurso,
                    c.nivel AS nivelCurso,
                    ac.codigo AS codAreaConhecimento,
                    ac.descricao AS descAreaConhecimento,
                    i.codigo AS codInstituicao,
                    i.descricao AS descInstituicao";            
        
        $ordem = "a.codigo, m.anoLetInicio, m.anoLetConclusao";

        $lista = $visualizacao->listar(null, $campos, $dados, $ordem);

        // echo "<pre>";            
        // print_r($dados['aluno']);
        // print_r($lista);

        try {
            $resultado = $this->calcularVert($lista, $dados['aluno']);
        } catch (Exception $e) {
            echo "Mensagem: " . $e->getMessage() . "\n Local: " . $e->getTraceAsString();
        }

        // $this->__set("listaVisualizacao", $resultado);
        
        return json_encode($resultado);
        // return "<br>Este método está sendo chamado!";
    } 

    public function calcularVert($dados, $codigos) {

        // echo "<pre>";
        // print_r($codigos);
        // print_r($dados);

        $concluido = [5, 6, 12, 13, 15, 18, 19, 23, 24];
        $matriculado = [0, 14, 16, 21];
        $evadido = [2, 3, 4, 7, 8, 9, 10, 11, 20, 22];

        // resposta padrão

        $resultado = array(
            'eixo' => array(
                'linhas' => array(
                        'Concluida' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0 ),
                        'NConcluida' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0 ),
                        'Fluxo' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0)
                ),
                'barras' => array(
                    'vert' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0 ),
                    'reingresso' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0 )
                ),
                'pizzas' => array(
                    'vert' => array( 'Concluida' => 0, 'NConcluida' => 0, 'Fluxo' => 0 ),
                    'reingresso' => array( 'Concluida' => 0, 'NConcluida' => 0, 'Fluxo' => 0 )
                )
            ),
            'foraEixo' => array(
                'linhas' => array(
                    'Concluida' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0 ),
                    'NConcluida' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0 ),
                    'Fluxo' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0 )
                ),
                'barras' => array(
                    'vert' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0 ),
                    'reingresso' => array( '2015' => 0, '2016' => 0, '2017' => 0, '2018' => 0, '2019' => 0, '2020' => 0 )
                ),
                'pizzas' => array(
                    'vert' => array( 'Concluida' => 0, 'NConcluida' => 0, 'Fluxo' => 0 ),
                    'reingresso' => array( 'Concluida' => 0, 'NConcluida' => 0, 'Fluxo' => 0 )
                )
            )
        );

        $alunos = array_column($dados, 'aluno'); // pega a key especifica em cada objeto dentro do array
        
        foreach ($codigos as $key => $value) {

            $dadosAluno = [];            
            $search = $value;
            // $search = 3553;

            while (!empty($key = array_search($search, $alunos))) {
                $dadosAluno[] = $dados[$key];
                $alunos[$key] = 0;
            } 

            for ($i=0; $i < count($dadosAluno); $i++) { 
                for ($j=$i+1; $j < count($dadosAluno); $j++) { 
                    
                    if ($dadosAluno[$i]->nivelCurso < $dadosAluno[$j]->nivelCurso) { // se subir de nível
                        // echo "<br>" . $dadosAluno[$i]->descCurso . $dadosAluno[$i]->situacao . " -> " . $dadosAluno[$j]->descCurso . $dadosAluno[$j]->situacao;
                        
                        if (in_array($dadosAluno[$i]->situacao, $concluido)) {

                            $tipo = "vert";
                            
                            if (in_array($dadosAluno[$j]->situacao, $concluido)) {                                 
                                $fase = "Concluida"; // Verticalização Concluída
                            } elseif (in_array($dadosAluno[$j]->situacao, $matriculado)) {
                                $fase = "Fluxo"; // Verticalização Em Fluxo
                            } elseif (in_array($dadosAluno[$j]->situacao, $evadido)) {
                                $fase = "NConcluida"; // Verticalização Não Concluída
                            }
                            
                        } elseif (in_array($dadosAluno[$i]->situacao, $evadido)) {

                            $tipo = "reingresso";
                            
                            if (in_array($dadosAluno[$j]->situacao, $concluido)) {
                                $fase = "Concluida"; // Verticalização Reingresso Concluída
                            } elseif (in_array($dadosAluno[$j]->situacao, $matriculado)) {
                                $fase = "Fluxo"; // Verticalização Reingresso Em Fluxo
                            } elseif (in_array($dadosAluno[$j]->situacao, $evadido)) {
                                $fase = "NConcluida"; // Verticalização Reingresso Não Concluída
                            }
                            
                        }

                        if ($dadosAluno[$i]->codAreaConhecimento == $dadosAluno[$j]->codAreaConhecimento) {
                            $eixo = "eixo";
                        } else {
                            $eixo = "foraEixo";
                        }
                        
                        $ano = $dadosAluno[$j]->anoLetInicio;
                        $campus = $dadosAluno[$j]->descInstituicao;
                        $area = $dadosAluno[$j]->descAreaConhecimento;
                        $sexo = $dadosAluno[$j]->sexo;

                        if (!isset($resultado[$eixo]['tabela'][$tipo.$fase][$campus][$area][$ano])) $resultado[$eixo]['tabela'][$tipo.$fase][$campus][$area][$ano] = 0;

                        $resultado[$eixo]['linhas'][$fase][$ano]++;
                        $resultado[$eixo]['barras'][$tipo][$ano]++;
                        $resultado[$eixo]['pizzas'][$tipo][$fase]++;
                        $resultado[$eixo]['tabela'][$tipo.$fase][$campus][$area][$ano]++;
                    }
                }
            }
        }      
        
        // echo "<pre>";
        // print_r($resultado);

        return $resultado;
    }
}
