<?php

namespace core\model;

use core\crud\CRUD;
use Exception;

class Visualizacao extends CRUD {

    const TABELA = "matricula";
    const COL_MATRICULA_COD = "codigo";
    const COL_ALUNO_COD = "aluno";
    const COL_SEXO = "sexo";
    const COL_SITUACAO = "situacao";
    const COL_ANO_INICIO = "anoLetInicio";
    const COL_ANO_CONCLUSAO = "anoLetConclusao";
    const COL_ANO_ATUAL = "anoLetAtual";
    const COL_CURSO_COD = "codCurso";
    const COL_CURSO_DESC = "descCurso";
    const COL_AREA_COD = "codAreaConhecimento";
    const COL_AREA_DESC = "descAreaConhecimento";
    const COL_INSTITUICAO_COD = "codInstituicao";
    const COL_INSTITUICAO_DESC = "descInstituicao";
    const LIMIT_ANO_INICIO = 2009;
    const LIMIT_ANO_ATUAL = 2020;

    /**
     * @param assunto da pesquisa, campos da tabela, filtros de busca, ordem da seleção
     * @return array
     */
    public function listar($assunto = null, $campos = null, $busca = [], $ordem = null) {
        
        $campos = $campos != null ? $campos : "*";
        $whereCondicao = "1 = 1";
        $whereValor = [];

        // GROUP BY
        if ($assunto == 'codigos') {
            $groupBy = self::COL_ALUNO_COD . " HAVING count(" . self::COL_ALUNO_COD . ") > 1 ";
        } elseif ($assunto == 'porcentagem') {
            $groupBy = $ordem;
        } else {
            $groupBy = null;
        }

        if ($campos == 'anoLetInicio') {
            $whereCondicao .= " AND " . self::COL_ANO_INICIO . " >= ?";
            $whereValor[] = self::LIMIT_ANO_INICIO;
            $ordem = self::COL_ANO_INICIO;
        }

        // TABELA e/ou INNER JOIN
        if ($assunto == 'filtro') {
            $campos = "DISTINCT $campos";
            $tabela = self::TABELA;
        } else {
            $tabela =  self::TABELA . " m
                        INNER JOIN aluno a ON m.aluno = a.codigo
                        INNER JOIN curso c ON m.curso = c.codigo
                        INNER JOIN areaConhecimento ac ON c.areaConhecimento = ac.codigo
                        INNER JOIN instituicao i ON m.instituicao = i.codigo";
        }

        // WHERE
        if (count((array)$busca) > 0) {
            if (isset($busca['anoLetInicio']) && !empty($busca['anoLetInicio'])) {
                $whereCondicao .= " AND m." . self::COL_ANO_INICIO . " >= ? ";
                $whereValor[] = $busca['anoLetInicio'];
            } else {
                $whereCondicao .= " AND m." . self::COL_ANO_INICIO . " >= ? ";
                $whereValor[] = self::LIMIT_ANO_INICIO;
            }

            if (isset($busca['anoLetAtual']) && !empty($busca['anoLetAtual'])) {
                $whereCondicao .= " AND m." . self::COL_ANO_ATUAL . " <= ? ";
                $whereValor[] = $busca['anoLetAtual'];
            } else {
                $whereCondicao .= " AND m." . self::COL_ANO_ATUAL . " <= ? ";
                $whereValor[] = self::LIMIT_ANO_ATUAL;
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

            if (isset($busca['situacao']) && !empty($busca['situacao'])) {
                $whereCondicao .= " AND m." . self::COL_SITUACAO . " IN (";

                for ($i=0; $i < count($busca['situacao'])-1; $i++) { 
                    $whereCondicao .= "?, ";
                    $whereValor[] = $busca['situacao'][$i];
                }

                $whereCondicao .= " ?)";
                $whereValor[] = end($busca['situacao']);
            }

            // $whereCondicao .= " c.nivel != ?";
            // $whereValor[] = 1;

        }    

        $retorno = [];

        try {            
            $retorno = $this->read($tabela, $campos, $whereCondicao, $whereValor, $groupBy, $ordem);
        } catch (Exception $e) {
            echo "Mensagem: " . $e->getMessage() . "\n Local: " . $e->getTraceAsString();
        }

        return $retorno;
    }

}
