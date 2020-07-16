<?php

namespace core\crud;

use PDO;
use PDOException;

class CRUD {

    private $dados_conexao = [
        "driver" => "mysql",
        "host" => null,
        "user" => null,
        "password" => null,
        "db" => null
    ];

    /**
     * Conexão com a PDO
     *
     * @var null
     */
    protected $conexao = null;

    /**
     * Statement
     *
     * @var null
     */
    protected $stmt = null;

    /**
     * Armazena a última consulta realizada para depuração
     *
     * @var string
     */
    private $ultimo_sql = "";

    /**
     * CRUD constructor.
     */
    public function __construct() {
        $this->openDB();
        $this->closeDB();
    }

    /**
     * Abre a conexão com o Banco de Dados
     *
     * @param bool $autocommit
     */
    protected function openDB($autocommit = false) {
        $dados_manifest = file_get_contents(ROOT . 'config-dev.json');
        $dados = json_decode($dados_manifest)->database;

        if ($dados !== null) {

            $this->dados_conexao['host'] = $dados->host;
            $this->dados_conexao['user'] = $dados->user;
            $this->dados_conexao['password'] = $dados->password;
            $this->dados_conexao['db'] = $dados->db;

            try {

                //Define utf8 como a formatação padrão de caracteres
                $opcoes = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                );

                //Habilita o auto-commit
                if (!$autocommit) {
                    $opcoes[PDO::ATTR_PERSISTENT] = true;
                }

                $this->conexao = new PDO(
                    "mysql:host={$this->dados_conexao['host']};dbname={$this->dados_conexao['db']}",
                    $this->dados_conexao['user'],
                    $this->dados_conexao['password'],
                    $opcoes
                );

            } catch (PDOException $e) {
                echo "Erro ao iniciar conexão: " . $e->getMessage() . "\n" . $e->getTraceAsString();
            }

        } else {
            echo "Dados para conexão inválidos";
        }
    }

    /**
     * Fecha a conexão com o Banco de Dados
     */
    protected function closeDB() {
        if ($this->conexao === null)
            throw new PDOException("Não há conexão aberta para fechar");

        $this->conexao = null;
    }

    protected function pegarUltimoSQL() {
        return $this->ultimo_sql;
    }


    /**
     * Efetua consultas no Banco de Dados
     *
     * @param $tabela - Nome da tabela com ou sem JOIN
     * @param null $campos - Quais os campos que devem ser retornados pelo método, separados por ','
     * @param null $where_condicao - Condição a ser verificada antes de selecionar os dados. Ex.: "campo = ?"
     * @param array $where_valor - Array com os valores que serão inseridos pelo método bindValue()
     * @param null $group_by - Nome do campo para realizar o agrupamento dos dados
     * @param null $ordem - O nome dos campos e a ordenação de cada um deles. Ex.: "campo1 ASC, campo2 DESC"
     * @return array
     */
    protected function read(
        $tabela,
        $campos = null,
        $where_condicao = null,
        $where_valor = [],
        $group_by = null,
        $ordem = null) {

        $campos = $campos == null ? "*" : $campos;

        $this->openDB();

        // Prepara a consulta SQL
        $sql = "SELECT " . $campos . " FROM " . $tabela . " ";
        $sql .= $where_condicao != null ? "WHERE " . $where_condicao . " " : "";
        $sql .= $group_by != null ? "GROUP BY " . $group_by . " " : "";
        $sql .= $ordem != null ? "ORDER BY " . $ordem . " " : "";
// echo "<br>$sql<br>";
        //Armazena a consulta SQL para verificação
        $this->ultimo_sql = $sql;

        $this->stmt = $this->conexao->prepare($sql);

        for ($i = 1; $i <= count($where_valor); $i++) {
            $this->stmt->bindValue($i, $where_valor[$i - 1]);
        }

        $this->stmt->execute();

        $resultado = $this->stmt->fetchAll(PDO::FETCH_OBJ);

        if (count($resultado) > 0 && isset($resultado[0])) {
            $lista = $resultado;
        } else {
            $lista = [$resultado];
        }

        $this->closeDB();

        return $lista;
    }

}
