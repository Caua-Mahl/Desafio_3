<?php
class Tarefa
{
    private int $id;
    private string $descricao;
    private int $projeto_id;
    private string $data_inicio;
    private string $data_fim;
    private static array $array_tarefas = [];
    private static $conn;

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
    public static function set_conn($conn)
    {
        self::$conn = $conn;
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
    public static function cadastrar_tarefa(Tarefa $tarefa)
    {
        self::$array_tarefas[] = $tarefa;
        pg_insert(self::$conn, 'tarefas', tarefa::tarefa_para_array($tarefa));

        //ver se tem como retornar o id que o banco gerar para salvar no array
    }
    public static function remover_tarefa(Tarefa $tarefa)
    {

        $id_tarefa = $tarefa->getId();
        $comando_sql = 'DELETE FROM tarefas WHERE id = $1';
        pg_query_params(self::$conn, $comando_sql, (array) $id_tarefa);

        // faz um loop para remover o tarefa do array de tarefas
        foreach (self::$array_tarefas as $indice => $tarefa) {
            if ($tarefa->getId() == $id_tarefa) {
                unset(self::$array_tarefas[$indice]);
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

        foreach (self::$array_tarefas as $indice => $tarefa) {
            if ($tarefa->getId() == $tarefa_convertida['id']) {
                self::$array_tarefas[$indice] = $tarefa;
                break;
            }
        }
    }
}