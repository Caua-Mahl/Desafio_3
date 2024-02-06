<?php

require_once "Conexao/Conn.php";
class Usuario extends Conn
{
    private string $token;
    private string $nome;

    public function __construct(string $token, string $nome)
    {
        $this->nome = $nome;
        $this->token = $token;
    }

    public function get_nome()
    {
        return $this->nome;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function setId(string $nome)
    {
        $this->nome = $nome;
    }
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public static function cadastrar_usuario(string $nome)
    {
        $token = Controlador::get_token();
        $query = "INSERT INTO usuario (\"token\",\"nome\") VALUES ($1, $2)";
        pg_query_params(self::$conn, $query, array($token, $nome));
        $usuario = new Usuario($token, $nome);

        return $usuario;
    }



}