<?php

require_once "Conexao/Conn.php";
class Tentativa extends Conn
{
    private string $token_usuario;
    private int $jogo_id;
    private string $resposta_1;
    private string $resposta_2;
    private string $resposta_3;
    private string $resposta_4;
    private string $resposta_5;
    private int $acertos;

    public function __construct(string $token_usuario, int $jogo_id, string $resposta_1, string $resposta_2, string $resposta_3, string $resposta_4, string $resposta_5, int $acertos)
    {

        $this->token_usuario = $token_usuario;
        $this->jogo_id = $jogo_id;
        $this->resposta_1 = $resposta_1;
        $this->resposta_2 = $resposta_2;
        $this->resposta_3 = $resposta_3;
        $this->resposta_4 = $resposta_4;
        $this->resposta_5 = $resposta_5;
        $this->acertos = $acertos;
    }

    public function gettoken_usuario()
    {
        return $this->token_usuario;
    }
    public function getJogo_id()
    {
        return $this->jogo_id;
    }
    public function getResposta_1()
    {
        return $this->resposta_1;
    }
    public function getResposta_2()
    {
        return $this->resposta_2;
    }
    public function getResposta_3()
    {
        return $this->resposta_3;
    }
    public function getResposta_4()
    {
        return $this->resposta_4;
    }
    public function getResposta_5()
    {
        return $this->resposta_5;
    }
    public function getAcertos()
    {
        return $this->acertos;
    }
    public function settoken_usuario(string $token_usuario)
    {
        $this->token_usuario = $token_usuario;
    }
    public function setJogo_id(int $jogo_id)
    {
        $this->jogo_id = $jogo_id;
    }
    public function setResposta_1(string $resposta_1)
    {
        $this->resposta_1 = $resposta_1;
    }
    public function setResposta_2(string $resposta_2)
    {
        $this->resposta_2 = $resposta_2;
    }
    public function setResposta_3(string $resposta_3)
    {
        $this->resposta_3 = $resposta_3;
    }
    public function setResposta_4(string $resposta_4)
    {
        $this->resposta_4 = $resposta_4;
    }
    public function setResposta_5(string $resposta_5)
    {
        $this->resposta_5 = $resposta_5;
    }
    public function setAcertos(int $acertos)
    {
        $this->acertos = $acertos;
    }
    public static function cadastrar_tentativa(string $token_usuario, int $jogo_id, string $resposta_1, string $resposta_2, string $resposta_3, string $resposta_4, string $resposta_5, int $acertos)
    {
        $query = "INSERT INTO tentativa (\"token_usuario\",\"id_jogo\",\"resposta_1\",\"resposta_2\",\"resposta_3\",\"resposta_4\",\"resposta_5\",\"acertos\") 
                      VALUES ($1, $2, $3, $4, $5, $6,$7,$8)";

        pg_query_params(self::$conn, $query, array($token_usuario, $jogo_id, $resposta_1, $resposta_2, $resposta_3, $resposta_4, $resposta_5, $acertos));
        $tentativa = new Tentativa($token_usuario, $jogo_id, $resposta_1, $resposta_2, $resposta_3, $resposta_4, $resposta_5, $acertos);

        return $tentativa;
    }
}