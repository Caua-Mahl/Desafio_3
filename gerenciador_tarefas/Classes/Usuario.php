<?php

require_once "Conn.php";

class Usuario extends Conn
{
    private int $id;
    private string $nome;
    private string $email;
    private static array $usuarios = [];

    public function __construct(int $id, string $nome, string $email)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;

    }
    public function get_id(): int
    {
        return $this->id;
    }
    public function get_nome(): string
    {
        return $this->nome;
    }
    public function get_email(): string
    {
        return $this->email;
    }

    public function set_id(int $id): void
    {
        $this->id = $id;
    }
    public function set_nome(string $nome): void
    {
        $this->nome = $nome;
    }
    public function set_email(string $email): void
    {
        $this->email = $email;
    }

    //essa função transofrma um objeto usuário em um array e retorna o array com as infos
    public static function usuario_para_array(Usuario $usuario): array
    {

        $usuario_array = array(
            'id' => $usuario->get_id(),
            'nome' => $usuario->get_nome(),
            'email' => $usuario->get_email()
        );

        return $usuario_array;
    }

    public static function cadastrar_usuario(string $nome, string $email)
    {
        $query = "INSERT INTO usuarios (\"nome\",\"email\") 
                      VALUES ($1, $2) RETURNING id";
        $resultado = pg_query_params(self::$conn, $query, array($nome, $email));

        if ($resultado) {
            $linha = pg_fetch_row($resultado);
            $usuario = new Usuario($linha[0], $nome, $email);
        }
        return $usuario;
    }

    public static function remover_usuario(Usuario $usuario)
    {

        $id_usuario = $usuario->get_id();
        $comando_sql = 'DELETE FROM usuarios WHERE id = $1';
        pg_query_params(self::$conn, $comando_sql, (array) $id_usuario);

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

    }
    public static function retorna_usuario_por_id(int $id_usuario)
    {

        $comando_sql = "SELECT * FROM usuarios WHERE id = $1";

        $resultado = pg_query_params(self::$conn, $comando_sql, (array) $id_usuario);
        $linhas = pg_fetch_assoc($resultado);

        $usuario = new Usuario($linhas['id'], $linhas['nome'], $linhas['email']);
        return $usuario;

    }
}