<?php
class Usuario
{
    private int $id;
    private string $nome;
    private string $email;
    private static array $usuarios = [];
    private static $conn;

    public function __construct(int $id, string $nome, string $email)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;

    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public static function listar_usuarios_do_array(): array
    {
        return self::$usuarios;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public static function set_conn($conn)
    {
        self::$conn = $conn;
    }

    //essa função transofrma um objeto usuário em um array e retorna o array com as infos
    public static function usuario_para_array(Usuario $usuario): array
    {

        $usuario_array = array(
            'id' => $usuario->getId(),
            'nome' => $usuario->getNome(),
            'email' => $usuario->getEmail()
        );

        return $usuario_array;
    }

    //recebe um usuario como parametro, converte para colocar no banco de dados e também adiciona no array de usuarios o usuario antes de ser convertido
    public static function cadastrar_usuario(Usuario $usuario)
    {
        self::$usuarios[] = $usuario;
        pg_insert(self::$conn, 'usuarios', Usuario::usuario_para_array($usuario));

        //ver se tem como retornar o id que o banco gerar para salvar no array
    }
    //essa função recebe o usuário e armazena o valor do id dele em uma variável, depois passa essa variavel para a query e executa o código
    //talvez se a gente passar o ID do usuario seja mais interessante, pois caso o index não tiver o usuario mas o banco sim, fica impossivel de remover
    public static function remover_usuario(Usuario $usuario)
    {

        $id_usuario = $usuario->getId();
        $comando_sql = 'DELETE FROM usuarios WHERE id = $1';
        pg_query_params(self::$conn, $comando_sql, (array) $id_usuario);

        // faz um loop para remover o usuario do array de usuarios
        foreach (self::$usuarios as $indice => $usuario) {
            if ($usuario->getId() == $id_usuario) {
                unset(self::$usuarios[$indice]);
                break;
            }
        }

    }
    //apenas um comando simples q retorna o resutlado da consulta no banco de dados
    public static function listar_usuarios_do_banco()
    {
        $comando_sql = "SELECT * FROM usuarios";
        $resultados = pg_query(self::$conn, $comando_sql);
        return $resultados;

    }
    //recebe como parametro um objeto do tipo usuario e escreve novamente seus atributos no banco
    public static function atualizar_usuario_no_banco(Usuario $usuario)
    {

        $usuario_convertido = self::usuario_para_array($usuario);
        $comando_sql = "UPDATE usuarios SET nome = \$2, email = \$3 WHERE id = \$1";
        pg_query_params(self::$conn, $comando_sql, $usuario_convertido);

        foreach (self::$usuarios as $indice => $usuario) {
            if ($usuario->getId() == $usuario_convertido['id']) {
                self::$usuarios[$indice] = $usuario;
                break;
            }
        }
    }
}