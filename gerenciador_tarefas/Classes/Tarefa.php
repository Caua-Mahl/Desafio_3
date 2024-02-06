<?php

require_once "Conn.php";

class Tarefa extends Conn
{
    private int $id;
    private string $descricao;
    private int $projeto_id;
    private string $data_inicio;
    private string $data_fim;

    public function __construct(int $id, string $descricao, int $projeto_id, string $data_inicio, string $data_fim)
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->projeto_id = $projeto_id;
        $this->data_inicio = $data_inicio;
        $this->data_fim = $data_fim;
    }

    public function get_id(): int
    {
        return $this->id;
    }
    public function get_descricao(): string
    {
        return $this->descricao;
    }
    public function get_projeto_id(): int
    {
        return $this->projeto_id;
    }
    public function get_data_inicio(): string
    {
        return $this->data_inicio;
    }
    public function get_data_fim(): string
    {
        return $this->data_fim;
    }

    public function set_descricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }
    public function set_data_inicio(string $data_inicio): void
    {
        $this->data_inicio = $data_inicio;
    }
    public function set_data_fim(string $data_fim): void
    {
        $this->data_fim = $data_fim;
    }

    public static function tarefa_para_array(Tarefa $tarefa): array
    {

        $tarefa_array = array(
            'id' => $tarefa->get_id(),
            'descricao' => $tarefa->get_descricao(),
            'projeto_id' => $tarefa->get_projeto_id(),
            'data_inicio' => $tarefa->get_data_inicio(),
            'data_fim' => $tarefa->get_data_fim(),

        );

        return $tarefa_array;
    }
    public static function cadastrar_tarefa(string $descricao, int $projeto_id, string $data_inicio, string $data_fim)
    {
        $query = "INSERT INTO tarefas (\"descricao\",\"projeto_id\",\"data_inicio\",\"data_fim\") 
                      VALUES ($1, $2, $3, $4) RETURNING id";
        $resultado = pg_query_params(self::$conn, $query, array($descricao, $projeto_id, $data_inicio, $data_fim));

        if ($resultado) {
            $linha = pg_fetch_row($resultado);
            $tarefa = new Tarefa($linha[0], $descricao, $projeto_id, $data_inicio, $data_fim);
        }
        return $tarefa;
    }

    public static function remover_tarefa(Tarefa $tarefa)
    {

        $id_tarefa = $tarefa->get_id();
        $comando_sql = 'DELETE FROM tarefas WHERE id = $1';
        pg_query_params(self::$conn, $comando_sql, (array) $id_tarefa);

    }
    public static function listar_tarefas_do_banco()
    {
        $comando_sql = "SELECT * FROM tarefas";
        $resultados = pg_query(self::$conn, $comando_sql);
        return $resultados;

    }
    public static function atualizar_tarefa_no_banco(Tarefa $tarefa)
    {
        $tarefa_convertida = self::tarefa_para_array($tarefa);
        $comando_sql = "UPDATE tarefas SET descricao = \$2, projeto_id = \$3, data_inicio = \$4, data_fim = \$5 WHERE id = \$1";
        pg_query_params(self::$conn, $comando_sql, $tarefa_convertida);

    }
    public static function retorna_tarefa_por_id(int $id_tarefa)
    {

        $comando_sql = "SELECT * FROM tarefas WHERE id = $1";
        $resultado = pg_query_params(self::$conn, $comando_sql, (array) $id_tarefa);
        $linhas = pg_fetch_assoc($resultado);

        $tarefa = new Tarefa($linhas['id'], $linhas['descricao'], $linhas['projeto_id'], $linhas['data_inicio'], $linhas['data_fim']);
        return $tarefa;

    }

}