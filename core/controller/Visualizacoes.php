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

        $aux = explode(" - ", $dados['periodos']);
        $dados['anoLetInicio'] = $aux[0];
        $dados['anoLetAtual'] = $aux[1];
        unset($dados['periodos']);

        $linhasColunas = $dados['tabela'];
        $linhasColunas['anos'] = array($aux[0], $aux[1]);
        unset($dados['tabela']);
        
        $campos = " a.codigo AS aluno";
        
        $listaCodigos = $visualizacao->listar('codigos', $campos, $dados, null);
        $dados['aluno'] = array_column($listaCodigos, 'aluno');
        
        $campos = " a.codigo AS aluno,
                    a.sexo AS sexo,
                    m.anoLetAtual AS anoLetAtual,
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
        // print_r($linhasColunas);
        // print_r($lista);

        try {
            $resultado = $this->calcularVert($lista, $dados['aluno'], $linhasColunas);
        } catch (Exception $e) {
            echo "Mensagem: " . $e->getMessage() . "\n Local: " . $e->getTraceAsString();
        }

        // $this->__set("listaVisualizacao", $resultado);
        
        return json_encode($resultado);
        // return "<br>Este método está sendo chamado!";
    } 

    public function setArray($estrutura, $valor) {
        foreach ($estrutura as $key => $value) {
            $estrutura[$key] = $valor;
        }

        return $estrutura;
    }

    public function calcularVert($dados, $codigos, $arrays) {

        $concluido = [5, 6, 12, 13, 15, 18, 19, 23, 24];
        $matriculado = [0, 14, 16, 21];
        $evadido = [2, 3, 4, 7, 8, 9, 10, 11, 20, 22];

        // resposta padrão
        $arrayFase = array( 'Concluida' => 0, 'NConcluida' => 0, 'Fluxo' => 0 );

        $arrayAnos = array_fill($arrays['anos'][0], ($arrays['anos'][1] - $arrays['anos'][0])+1, 0);
        
        $arrayAreas = array_flip($arrays['areas']);
        $arrayAreas = $this->setArray($arrayAreas, 0);
        
        $arrayCampus = array_flip($arrays['unidades']);
        $arrayCampus = $this->setArray($arrayCampus, $arrayAreas);
        
        $arrayLinhas = array( 'Concluida' => $arrayAnos, 'NConcluida' => $arrayAnos, 'Fluxo' => $arrayAnos );
        $arrayBarras = array( 'vert' => $arrayAnos, 'reingresso' => $arrayAnos );
        $arrayPizzas = array( 'vert' => $arrayFase, 'reingresso' => $arrayFase );

        $resultado = array( 'linhas' => $arrayLinhas, 'barras' => $arrayBarras, 'pizzas' => $arrayPizzas );

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
                            
                        } else {
                            break;
                        }
                        
                        if ($fase == 'Concluida') {
                            if ($dadosAluno[$j]->anoLetConclusao != "") {
                                $ano = $dadosAluno[$j]->anoLetConclusao;
                            } elseif ($dadosAluno[$j]->anoLetAtual != "") {
                                $ano = $dadosAluno[$j]->anoLetAtual;
                            } else {
                                $ano = $dadosAluno[$j]->anoLetInicio;
                            }
                        } elseif ($fase == 'NConcluida') {
                            if ($dadosAluno[$j]->anoLetAtual != "") {
                                $ano = $dadosAluno[$j]->anoLetAtual;
                            } else {
                                $ano = $dadosAluno[$j]->anoLetInicio;
                            }
                        } elseif ($fase == 'Fluxo') {
                            $ano = $dadosAluno[$j]->anoLetInicio;
                        } 
                        
                        
                        $campus = $dadosAluno[$j]->descInstituicao;
                        $area = $dadosAluno[$j]->descAreaConhecimento;

                        if ($dadosAluno[$i]->codInstituicao == $dadosAluno[$j]->codInstituicao) {

                            if(!isset($resultado['tabela'][$tipo.$fase][$campus]['foraArea']))
                                $resultado['tabela'][$tipo.$fase][$campus]['foraArea'] = $arrayAnos;
                            
                            if(!isset($resultado['tabela'][$tipo.$fase][$campus][$area]))
                                $resultado['tabela'][$tipo.$fase][$campus][$area] = $arrayAnos;
                            
                            
                            if ($dadosAluno[$i]->codAreaConhecimento != $dadosAluno[$j]->codAreaConhecimento) {
                                $resultado['tabela'][$tipo.$fase][$campus]['foraArea'][$ano]++;
                            } else {                                
                                $resultado['tabela'][$tipo.$fase][$campus][$area][$ano]++;
                            }
                            
                        } else {
                            
                            if(!isset($resultado['tabela'][$tipo.$fase]['foraCampus']['foraArea']))
                                $resultado['tabela'][$tipo.$fase]['foraCampus']['foraArea'] = $arrayAnos;
                            
                            if(!isset($resultado['tabela'][$tipo.$fase]['foraCampus'][$area]))
                                $resultado['tabela'][$tipo.$fase]['foraCampus'][$area] = $arrayAnos;
                            
                            if ($dadosAluno[$i]->codAreaConhecimento != $dadosAluno[$j]->codAreaConhecimento) {
                                $resultado['tabela'][$tipo.$fase]['foraCampus']['foraArea'][$ano]++;
                            } else {                                
                                $resultado['tabela'][$tipo.$fase]['foraCampus'][$area][$ano]++;
                            }          
                        }

                        if(!isset($resultado['linhas'][$fase][$ano])) $resultado['linhas'][$fase][$ano] = 0;
                        if(!isset($resultado['barras'][$tipo][$ano])) $resultado['barras'][$tipo][$ano] = 0;
                        if(!isset($resultado['pizzas'][$tipo][$fase])) $resultado['pizzas'][$tipo][$fase] = 0;

                        $resultado['linhas'][$fase][$ano]++;
                        $resultado['barras'][$tipo][$ano]++;
                        $resultado['pizzas'][$tipo][$fase]++;
                    }
                }
            }
        }      
        
        // echo "<pre>";
        // print_r($resultado);

        return $resultado; 
    }
}
