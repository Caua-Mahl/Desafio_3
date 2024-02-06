<?php

require_once "Conn.php";

class Tarefa extends Conn
{
    private int $id;
    private string $descricao;
    private int $projeto_id;
    private string $data_inicio;
    private string $data_fim;
    private static array $tarefas = [];

    public function __construct(int $id, string $descricao, int $projeto_id, string $data_inicio, string $data_fim)
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->projeto_id = $projeto_id;
        $this->data_inicio = $data_inicio;
        $this->data_fim = $data_fim;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getDescricao(): string
    {
        return $this->descricao;
    }
    public function getProjetoId(): int
    {
        return $this->projeto_id;
    }
    public function getDataInicio(): string
    {
        return $this->data_inicio;
    }
    public function getDataFim(): string
    {
        return $this->data_fim;
    }
    public static function getTarefas(): array
    {
        return self::$tarefas;
    }
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }
    public function setDataInicio(string $data_inicio): void
    {
        $this->data_inicio = $data_inicio;
    }
    public function setDataFim(string $data_fim): void
    {
        $this->data_fim = $data_fim;
    }
    
    public static function tarefa_para_array(Tarefa $tarefa): array
    {

        $tarefa_array = array(
            'id' => $tarefa->getId(),
            'descricao' => $tarefa->getDescricao(),
            'projeto_id' => $tarefa->getProjetoId(),
            'data_inicio' => $tarefa->getDataInicio(),
            'data_fim' => $tarefa->getDataFim(),

        );

        return $tarefa_array;
    }
    public static function cadastrar_tarefa(string $descricao, int $projeto_id, string $data_inicio, string $data_fim)
    {
        $query     = "INSERT INTO tarefas (\"descricao\",\"projeto_id\",\"data_inicio\",\"data_fim\") 
                      VALUES ($1, $2, $3, $4) RETURNING id";
        $resultado = pg_query_params(self::$conn, $query, array($descricao, $projeto_id, $data_inicio, $data_fim));
        
        if ($resultado) {
            $linha           = pg_fetch_row($resultado);
            $tarefa          = new Tarefa($linha[0], $descricao, $projeto_id, $data_inicio, $data_fim);
            self::$tarefas[] = $tarefa;
        }
    }

    public static function remover_tarefa(Tarefa $tarefa)
    {

        $id_tarefa = $tarefa->getId();
        $comando_sql = 'DELETE FROM tarefas WHERE id = $1';
        pg_query_params(self::$conn, $comando_sql, (array) $id_tarefa);

        // faz um loop para remover o tarefa do array de tarefas
        foreach (self::$tarefas as $indice => $tarefa) {
            if ($tarefa->getId() == $id_tarefa) {
                unset(self::$tarefas[$indice]);
                break;
            }
        }
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

        foreach (self::$tarefas as $indice => $tarefa) {
            if ($tarefa->getId() == $tarefa_convertida['id']) {
                self::$tarefas[$indice] = $tarefa;
                break;
            }
        }
    }
    // public function listar_por_id($conexao, int $id)
    // {
    //     $query = "SELECT * FROM funcionarios WHERE id = $id";
    //     $retorno = pg_query($conexao, $query);
    //     $linhas = pg_fetch_assoc($retorno);

    //     $funcionario = new Funcionario(0, '', '', 0, 0);
    //     $funcionario->id = $linhas["id"];
    //     $funcionario->nome = $linhas["nome"];
    //     $funcionario->genero = $linhas["genero"];
    //     $funcionario->idade = $linhas["idade"];
    //     $funcionario->salario = $linhas["salario"];

    //     return $funcionario;

    // }
}