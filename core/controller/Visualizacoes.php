<?php

namespace core\controller;

require_once "../core/crud/CRUD.php";

use core\model\Visualizacao;

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
     * $campos = null, $busca = [], $ordem = null
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
        
        $ordem = "a.codigo, c.nivel, m.anoLetInicio, m.anoLetConclusao, m.anoLetAtual";

        $lista = $visualizacao->listar(null, $campos, $dados, $ordem);

        try {
            $resultado = $this->calcularVert($lista, $dados);
        } catch (Exception $e) {
            echo "Mensagem: " . $e->getMessage() . "\n Local: " . $e->getTraceAsString();
        }

        // $this->__set("listaVisualizacao", $resultado);
        
        return json_encode($resultado);
    } 

    // setar um determinado valor em um determinado array
    public function setArray($estrutura, $valor) {
        foreach ($estrutura as $key => $value) {
            $estrutura[$key] = $valor;
        }

        return $estrutura;
    }

    public function calcularVert($dados, $filtros) {

        $codigos = $filtros['aluno'];
        unset($filtros['aluno']);

        $situacoes = [
            'concluido' => [5, 6, 12, 13, 15, 18, 19, 23, 24],
            'matriculado' => [0, 14, 16, 21],
            'evadido' => [2, 3, 4, 7, 8, 9, 10, 11, 20, 22]
        ];

        // resposta padrão
        $arrayFase = array( 'Concluida' => 0, 'NConcluida' => 0, 'Fluxo' => 0 );

        $arrayAnos = array_fill($filtros['anoLetInicio'], ($filtros['anoLetAtual'] - $filtros['anoLetInicio'])+1, 0);
        
        $arrayLinhas = array( 'Concluida' => $arrayAnos, 'NConcluida' => $arrayAnos, 'Fluxo' => $arrayAnos );
        $arrayBarras = array( 'vert' => $arrayAnos, 'reingresso' => $arrayAnos );
        $arrayPizzas = array( 'vert' => $arrayFase, 'reingresso' => $arrayFase );

        $resultado = array( 'linhas' => $arrayLinhas, 'barras' => $arrayBarras, 'pizzas' => $arrayPizzas );

        $alunos = array_column($dados, 'aluno'); // pega a key especifica em cada objeto dentro do array

        $teste = [];
        
        foreach ($codigos as $key => $value) {

            $dadosAluno = [];            
            $search = $value;

            while (!empty($key = array_search($search, $alunos))) {
                $dadosAluno[] = $dados[$key];
                $alunos[$key] = 0;
            } 

            for ($i=0; $i < count($dadosAluno); $i++) { 
                for ($j=$i+1; $j < count($dadosAluno); $j++) { 
                    
                    if ($dadosAluno[$i]->nivelCurso < $dadosAluno[$j]->nivelCurso) { // se subir de nível
                        
                        $anoI = $dadosAluno[$i]->anoLetConclusao != "" ? $dadosAluno[$i]->anoLetConclusao : $dadosAluno[$i]->anoLetAtual;
                        $anoJ = $dadosAluno[$j]->anoLetConclusao != "" ? $dadosAluno[$j]->anoLetConclusao : $dadosAluno[$j]->anoLetAtual;

                        if (in_array($dadosAluno[$i]->situacao, $situacoes['concluido']) && $anoJ < $anoI) {

                            $tipo = "vert";                            

                            if (in_array($dadosAluno[$j]->situacao, $situacoes['concluido'])) {                                 
                                $fase = "Concluida"; // Verticalização Concluída
                            } elseif (in_array($dadosAluno[$j]->situacao, $situacoes['matriculado'])) {
                                $fase = "Fluxo"; // Verticalização Em Fluxo
                            } elseif (in_array($dadosAluno[$j]->situacao, $situacoes['evadido'])) {
                                $fase = "NConcluida"; // Verticalização Não Concluída
                            }
                            
                        } elseif (in_array($dadosAluno[$i]->situacao, $situacoes['evadido']) && $anoJ < $anoI) {

                            $tipo = "reingresso";
                            
                            if (in_array($dadosAluno[$j]->situacao, $situacoes['concluido'])) {
                                $fase = "Concluida"; // Verticalização Reingresso Concluída
                            } elseif (in_array($dadosAluno[$j]->situacao, $situacoes['matriculado'])) {
                                $fase = "Fluxo"; // Verticalização Reingresso Em Fluxo
                            } elseif (in_array($dadosAluno[$j]->situacao, $situacoes['evadido'])) {
                                $fase = "NConcluida"; // Verticalização Reingresso Não Concluída
                            }
                            
                        } else {
                            break; // primeiro curso em andamento não se classifica como verticalização
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

                        $campus = $dadosAluno[$j]->codInstituicao;

                        if ($dadosAluno[$i]->codAreaConhecimento != $dadosAluno[$j]->codAreaConhecimento) {
                            $area = 'zforaArea';
                        } else {
                            $area = $dadosAluno[$j]->codAreaConhecimento;
                        }

                        if ($dadosAluno[$i]->codInstituicao == $dadosAluno[$j]->codInstituicao) {
                            
                            if(!isset($resultado['tabela'][$tipo.$fase][$campus][$area]))
                                $resultado['tabela'][$tipo.$fase][$campus][$area] = $arrayAnos;
                            
                            if(!isset($resultado['tabela']['independente'][$campus][$area]))
                                $resultado['tabela']['independente'][$campus][$area] = $arrayAnos;
                            
                            $resultado['tabela'][$tipo.$fase][$campus][$area][$ano]++;
                            $resultado['tabela']['independente'][$campus][$area][$ano]++;
                            
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
        
        $resultado['tabela'] = $this->calcularPorcentagem($resultado['tabela'], $situacoes, $filtros);

        return $resultado; 
    }

    public function calcularPorcentagem($dados, $situacoes, $busca) {
        $visualizacao = new Visualizacao();
        
        foreach ($dados as $tipo => $unidades) { 
            
            if (strpos($tipo, 'Concluida')) {
                $busca['situacao'] = $situacoes['concluido'];   
                $ano = 'anoLetConclusao';             
            } elseif (strpos($tipo, 'NConcluida')) {
                $busca['situacao'] = $situacoes['evadido'];
                $ano = 'anoLetAtual';
            } elseif (strpos($tipo, 'Fluxo')) {
                $busca['situacao'] = $situacoes['matriculado'];
                $ano = 'anoLetInicio';
            } else {
                $busca['situacao'] = "";
                $ano = 'anoLetInicio';
            }

            $campos = " m.$ano AS ano,
                        count(m.$ano) AS qtde";            
            
            $ordem = "i.codigo, ac.codigo, m.$ano";            

            foreach ($unidades as $unidade => $areas) {
                foreach ($areas as $area => $anos) {
                    $busca['codInstituicao'] = [$unidade];
                    $busca['codAreaConhecimento'] = [$area];
                    
                    $lista = $visualizacao->listar('porcentagem', $campos, $busca, $ordem);

                    $ano = array_column($lista, 'ano');
                    $qtde = array_column($lista, 'qtde');

                    foreach ($anos as $key => $value) {
                        $a = array_search($key, $ano);
                        
                        if (isset($qtde[$a]) && !empty($qtde[$a]) && $qtde[$a] != 0) {
                            $dados[$tipo][$unidade][$area][$key] = round((($value/$qtde[$a])*100), 1); // cálculo
                        } else {
                            // $dados[$tipo][$unidade][$area][$key] = '#';
                        }
                    }


                }
            }
        }

        return $dados;
    }
}
