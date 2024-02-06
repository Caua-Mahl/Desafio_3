<?php

require_once "Conn.php";

class Projeto extends Conn
{
    private int $id;
    private string $nome;
    private string $descricao;
    private string $data_inicio;
    private string $data_fim;

    public function __construct(int $id, string $nome, string $descricao, string $data_inicio, string $data_fim)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->data_inicio = $data_inicio;
        $this->data_fim = $data_fim;
    }

    public function get_id(): int
    {
        return $this->id;
    }
    public function get_nome(): string
    {
        return $this->nome;
    }
    public function get_descricao(): string
    {
        return $this->descricao;
    }
    public function get_data_inicio(): string
    {
        return $this->data_inicio;
    }
    public function get_data_fim(): string
    {
        return $this->data_fim;
    }
    public function set_nome(string $nome): void
    {
        $this->nome = $nome;
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
    //transforma um objeto PROJETO em um array associativo
    public static function projeto_para_array(Projeto $projeto)
    {
        $projeto_array = array(
            'id' => $projeto->get_id(),
            'nome' => $projeto->get_nome(),
            'descricao' => $projeto->get_descricao(),
            'data_inicio' => $projeto->get_data_inicio(),
            'data_fim' => $projeto->get_data_fim()
        );

        return $projeto_array;
    }

    //cadastra um projeto no banco de dados
    //chama a função converte_para_array para conseguir enviar para o banco os dados
    public static function cadastrar_projeto(string $nome, string $descricao, string $data_inicio, string $data_fim)
    {
        $query = "INSERT INTO projetos (\"nome\",\"descricao\",\"data_inicio\",\"data_fim\") 
                  VALUES ($1, $2, $3, $4) RETURNING id";
        $resultado = pg_query_params(self::$conn, $query, array($nome, $descricao, $data_inicio, $data_fim));

        if ($resultado) {
            $linha = pg_fetch_row($resultado);
            $projeto = new Projeto($linha[0], $nome, $descricao, $data_inicio, $data_fim);
        }
        return $projeto;
    }

    //recebe um objeto projeto e faz o get do ID para verificar se existe no banco, caso sim exclui do banco e do array de usuarios
    public static function remover_projeto(Projeto $projeto)
    {
        $id_projeto = $projeto->get_id();
        $comando_sql = 'DELETE FROM projetos WHERE id = $1';
        pg_query_params(self::$conn, $comando_sql, (array) $id_projeto);


    }
    //comando simples para retornar o resultado do select daa tabela
    public static function listar_projetos_do_banco()
    {
        $comando_sql = "SELECT * FROM projetos";
        $resultados = pg_query(self::$conn, $comando_sql);
        return $resultados;

    }
    //recebe como argumento um objeto PROJETO e escreve novamente seus atributos no banco
    public static function atualizar_projeto_no_banco(Projeto $projeto)
    {
        $projeto_convertido = self::projeto_para_array($projeto);
        $comando_sql = "UPDATE projetos SET nome = \$2, descricao = \$3, data_inicio = \$4, data_fim = \$5 WHERE id = \$1";
        pg_query_params(self::$conn, $comando_sql, $projeto_convertido);

    }
    public static function retorna_projeto_por_id(int $id_projeto)
    {
        $comando_sql = "SELECT * FROM projetos WHERE id = $1";
        $resultado = pg_query_params(self::$conn, $comando_sql, (array) $id_projeto);
        $linhas = pg_fetch_assoc($resultado);

        $projeto = new Projeto($linhas['id'], $linhas['nome'], $linhas['descricao'], $linhas['data_inicio'], $linhas['data_fim']);
        return $projeto;
    }


}