<?php

require_once "Conn.php";

class Atribuicao extends Conn
{
    private int $id;
    private int $tarefa_id;
    private int $usuario_id;
    private string $data_atribuicao;
    private static array $array_atribuicoes = [];


    public function __construct(int $id, int $tarefa_id, int $usuario_id, string $data_atribuicao)
    {
        $this->id = $id;
        $this->tarefa_id = $tarefa_id;
        $this->usuario_id = $usuario_id;
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
    public static function cadastrar_atribuicao(Atribuicao $atribuicao)
    {
        self::$array_atribuicoes[] = $atribuicao;
        pg_insert(self::$conn, 'atribuicoes', atribuicao::atribuicao_para_array($atribuicao));

        //ver se tem como retornar o id que o banco gerar para salvar no array
    }
    public static function remover_atribuicao(Atribuicao $atribuicao)
    {

        $id_atribuicao = $atribuicao->getId();
        $comando_sql = 'DELETE FROM atribuicoes WHERE id = $1';
        pg_query_params(self::$conn, $comando_sql, (array) $id_atribuicao);

        // faz um loop para remover o atribuicao do array de atribuicaos
        foreach (self::$array_atribuicoes as $indice => $atribuicao) {
            if ($atribuicao->getId() == $id_atribuicao) {
                unset(self::$array_atribuicoes[$indice]);
                break;
            }
        }

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

        foreach (self::$array_atribuicoes as $indice => $atribuicao) {
            if ($atribuicao->getId() == $atribuicao_convertido['id']) {
                self::$array_atribuicoes[$indice] = $atribuicao;
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