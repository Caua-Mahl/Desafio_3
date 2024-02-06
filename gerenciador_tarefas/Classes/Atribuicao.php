<?php

require_once "Conn.php";

class Atribuicao extends Conn
{
    private int $id;
    private int $tarefa_id;
    private int $usuario_id;
    private string $data_atribuicao;

    public function __construct(int $id, int $usuario_id, int $tarefa_id, string $data_atribuicao)
    {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->tarefa_id = $tarefa_id;
        $this->data_atribuicao = $data_atribuicao;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getTarefaId(): int
    {
        return $this->tarefa_id;
    }
    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }
    public function getDataAtribuicao(): string
    {
        return $this->data_atribuicao;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setTarefaId(int $tarefa_id): void
    {
        $this->tarefa_id = $tarefa_id;
    }
    public function setUsuarioId(int $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }
    public function setDataAtribuicao(string $data_atribuicao): void
    {
        $this->data_atribuicao = $data_atribuicao;
    }
    public static function atribuicao_para_array(Atribuicao $atribuicao): array
    {

        $atribuicao_array = array(
            'id' => $atribuicao->getId(),
            'usuario_id' => $atribuicao->getUsuarioId(),
            'tarefa_id' => $atribuicao->getTarefaId(),
            'data_atribuicao' => $atribuicao->getDataAtribuicao()
        );

        return $atribuicao_array;
    }
    public static function cadastrar_atribuicao(int $tarefa_id, int $usuario_id, string $data_atribuicao)
    {
        $query = "INSERT INTO atribuicoes (\"usuario_id\",\"tarefa_id\",\"data_atribuicao\") 
                      VALUES ($1, $2, $3) RETURNING id";
        $resultado = pg_query_params(self::$conn, $query, array($usuario_id, $tarefa_id, $data_atribuicao));

        if ($resultado) {
            $linha = pg_fetch_row($resultado);
            $atribuicao = new Atribuicao($linha[0], $usuario_id, $tarefa_id, $data_atribuicao);
        }
        return $atribuicao;
    }
    public static function remover_atribuicao(Atribuicao $atribuicao)
    {

        $id_atribuicao = $atribuicao->getId();
        $comando_sql = 'DELETE FROM atribuicoes WHERE id = $1';
        pg_query_params(self::$conn, $comando_sql, (array) $id_atribuicao);

    }
    public static function listar_atribuicoes_do_banco()
    {
        $comando_sql = "SELECT * FROM atribuicoes";
        $resultados = pg_query(self::$conn, $comando_sql);
        return $resultados;

    }

    public static function atualizar_atribuicao_no_banco(Atribuicao $atribuicao)
    {
        $atribuicao_convertido = self::atribuicao_para_array($atribuicao);
        $comando_sql = "UPDATE atribuicoes SET tarefa_id = \$2, usuario_id = \$3, data_atribuicao = \$4 WHERE id = \$1";
        pg_query_params(self::$conn, $comando_sql, $atribuicao_convertido);

    }
    public static function retorna_atribuicao_por_id(int $id_atribuicao)
    {

        $comando_sql = "SELECT * FROM atribuicoes WHERE id = $1";
        $resultado = pg_query_params(self::$conn, $comando_sql, (array) $id_atribuicao);
        $linhas = pg_fetch_assoc($resultado);

        $atribuicao = new Atribuicao($linhas['id'], $linhas['usuario_id'], $linhas['tarefa_id'], $linhas['data_atribuicao']);
        return $atribuicao;

    }

}