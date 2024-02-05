<?php
require "interfaces/iConexao.php";

class Projeto implements IConexao
{
    private int $id;
    private string $nome;
    private string $descricao;
    private string $data_inicio;
    private string $data_fim;
    private static array $array_projetos = [];
    private static $conn;


    public function __construct(int $id, string $nome, string $descricao, string $data_inicio, string $data_fim)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->data_inicio = $data_inicio;
        $this->data_fim = $data_fim;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }
    public function getDescricao(): string
    {
        return $this->descricao;
    }
    public function getDataInicio(): string
    {
        return $this->data_inicio;
    }
    public function getDataFim(): string
    {
        return $this->data_fim;
    }
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
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
    //transforma um objeto PROJETO em um array associativo
    public static function projeto_para_array(Projeto $projeto)
    {
        $projeto_array = array(
            'id' => $projeto->getId(),
            'nome' => $projeto->getNome(),
            'descricao' => $projeto->getDescricao(),
            'data_inicio' => $projeto->getDataInicio(),
            'data_fim' => $projeto->getDataFim()
        );

        return $projeto_array;
    }

    //cadastra um projeto no banco de dados
    //chama a função converte_para_array para conseguir enviar para o banco os dados
    public static function cadastrar_projeto(Projeto $projeto)
    {
        self::$array_projetos[] = $projeto;
        pg_insert(self::$conn, 'projetos', Projeto::projeto_para_array($projeto));

        //ver se tem como retornar o id que o banco gerar para salvar no array
    }
    //recebe um objeto projeto e faz o get do ID para verificar se existe no banco, caso sim exclui do banco e do array de usuarios
    public static function remover_projeto(Projeto $projeto)
    {
        $id_projeto = $projeto->getId();
        $comando_sql = 'DELETE FROM projetos WHERE id = $1';
        pg_query_params(self::$conn, $comando_sql, (array) $id_projeto);

        // faz um loop para remover o usuario do array de usuarios
        foreach (self::$array_projetos as $indice => $projeto) {
            if ($projeto->getId() == $id_projeto) {
                unset(self::$array_projetos[$indice]);
                break;
            }
        }
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

        foreach (self::$array_projetos as $indice => $projeto) {
            if ($projeto->getId() == $projeto_convertido['id']) {
                self::$array_projetos[$indice] = $projeto;
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