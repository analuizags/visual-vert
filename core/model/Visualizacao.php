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
        $ordem = $ordem != null ? $ordem : $campos . " ASC";
        $where_condicao = "1 = 1";
        $where_valor = [];


        if ($campos == 'anoLetInicio') {
            $where_condicao .= " AND " . self::COL_ANO_INICIO . " >= ?";
            $where_valor[] = '2015';

            $where_condicao .= " AND " . self::COL_ANO_INICIO . " <= ?";
            $where_valor[] = '2020';
        }

        $campos = $assunto == 'filtro' ? "DISTINCT $campos" : "";

        $retorno = [];

        try {

            $retorno = $this->read(self::TABELA, $campos, $where_condicao, $where_valor, $busca, $ordem);

        } catch (Exception $e) {
            echo "Mensagem: " . $e->getMessage() . "\n Local: " . $e->getTraceAsString();
        }

        return $retorno;
    }

}

?>