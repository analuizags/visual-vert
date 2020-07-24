<?php

namespace core\model;

use core\crud\CRUD;
use Exception;

class Visualizacao extends CRUD {

    const TABELA = "vertGraficos";
    const COL_MATRICULA_COD = "codigo";
    const COL_ALUNO_COD = "aluno";
    const COL_SEXO_DESC = "sexo";
    const COL_ANO_INICIO = "anoLetInicio";
    const COL_ANO_CONCLUSAO = "anoLetConclusao";
    const COL_CURSO_COD = "codCurso";
    const COL_CURSO_DESC = "descCurso";
    const COL_AREA_COD = "codAreaConhecimento";
    const COL_AREA_DESC = "descAreaConhecimento";
    const COL_INSTITUICAO_COD = "codInstituicao";
    const COL_INSTITUICAO_DESC = "descInstituicao";

    /**
     * @param $evento_id
     * @return array
     */
    public function listar($assunto = null, $campos = null, $busca = [], $ordem = null) {

        if ($campos == 'curso' || $campos == 'areaConhecimento' || $campos == 'instituicao') {
            $campos = "cod".ucfirst($campos).", desc".ucfirst($campos)." ";
        }
        
        $campos = $campos != null ? $campos : "*";
        $whereCondicao = "1 = 1";
        $whereValor = [];
        $groupBy = $assunto == 'codigos' ? " aluno HAVING count(aluno) > 1 " : null;


        if ($campos == 'anoLetInicio') {
            $whereCondicao .= " AND " . self::COL_ANO_INICIO . " >= ?";
            $whereValor[] = '2015';
        }

        if ($assunto == 'filtro') {
            $campos = "DISTINCT $campos";
            $tabela = self::TABELA;
        } else {
            $tabela = "matricula m
                        INNER JOIN aluno a ON m.aluno = a.codigo
                        INNER JOIN curso c ON m.curso = c.codigo
                        INNER JOIN areaConhecimento ac ON c.areaConhecimento = ac.codigo
                        INNER JOIN instituicao i ON m.instituicao = i.codigo";
        }

        if (count((array)$busca) > 0) {
            if (isset($busca['anoLetInicio']) && !empty($busca['anoLetInicio']) && count($busca['anoLetInicio']) != 6) {
                $whereCondicao .= " AND m.anoLetInicio IN (";

                for ($i=0; $i < count($busca['anoLetInicio'])-1; $i++) { 
                    $whereCondicao .= "?, ";
                    $whereValor[] = $busca['anoLetInicio'][$i];
                }

                $whereCondicao .= " ?)";
                $whereValor[] = end($busca['anoLetInicio']);
            } else {
                $whereCondicao .= " AND m.anoLetInicio >= ? ";
                // $whereCondicao .= " AND (m.anoLetInicio >= ? OR m.anoLetAtual >= ?) ";
                $whereValor[] = 2009;
                // $whereValor[] = 2015;
            }

            if (isset($busca['codAreaConhecimento']) && !empty($busca['codAreaConhecimento']) && count($busca['codAreaConhecimento']) != 7) {
                $whereCondicao .= " AND ac.codigo IN (";

                for ($i=0; $i < count($busca['codAreaConhecimento'])-1; $i++) { 
                    $whereCondicao .= "?, ";
                    $whereValor[] = $busca['codAreaConhecimento'][$i];
                }

                $whereCondicao .= " ?)";
                $whereValor[] = end($busca['codAreaConhecimento']);
            }

            if (isset($busca['codInstituicao']) && !empty($busca['codInstituicao']) && count($busca['codInstituicao']) != 12) {
                $whereCondicao .= " AND i.codigo IN (";

                for ($i=0; $i < count($busca['codInstituicao'])-1; $i++) { 
                    $whereCondicao .= "?, ";
                    $whereValor[] = $busca['codInstituicao'][$i];
                }

                $whereCondicao .= " ?)";
                $whereValor[] = end($busca['codInstituicao']);
            }

            if (isset($busca['sexo']) && !empty($busca['sexo']) && count($busca['sexo']) != 2) {
                $whereCondicao .= " AND a.sexo IN (";

                for ($i=0; $i < count($busca['sexo'])-1; $i++) { 
                    $whereCondicao .= "?, ";
                    $whereValor[] = $busca['sexo'][$i];
                }

                $whereCondicao .= " ?)";
                $whereValor[] = end($busca['sexo']);
            }

            if (isset($busca['aluno']) && !empty($busca['aluno'])) {
                $whereCondicao .= " AND a.codigo IN (";

                for ($i=0; $i < count($busca['aluno'])-1; $i++) { 
                    $whereCondicao .= "?, ";
                    $whereValor[] = $busca['aluno'][$i];
                }

                $whereCondicao .= " ?)";
                $whereValor[] = end($busca['aluno']);
            }

            // $whereCondicao .= " c.nivel != ?";
            // $whereValor[] = 1;

        }    

        // print_r($whereValor);
        $retorno = [];

        try {
            
            $retorno = $this->read($tabela, $campos, $whereCondicao, $whereValor, $groupBy, $ordem);
            
        } catch (Exception $e) {
            echo "Mensagem: " . $e->getMessage() . "\n Local: " . $e->getTraceAsString();
        }

        return $retorno;
    }

}

?>