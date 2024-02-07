<?php

require_once "Conexao/Conn.php";
class Jogo extends Conn
{
    private int $id;
    private int $Id_pergunta1;
    private int $Id_pergunta2;
    private int $Id_pergunta3;
    private int $Id_pergunta4;
    private int $Id_pergunta5;

    public function __construct(int $id, int $Id_pergunta1, int $Id_pergunta2, int $Id_pergunta3, int $Id_pergunta4, int $Id_pergunta5)
    {
        $this->id = $id;
        $this->Id_pergunta1 = $Id_pergunta1;
        $this->Id_pergunta2 = $Id_pergunta2;
        $this->Id_pergunta3 = $Id_pergunta3;
        $this->Id_pergunta4 = $Id_pergunta4;
        $this->Id_pergunta5 = $Id_pergunta5;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getId_pergunta1()
    {
        return $this->Id_pergunta1;
    }
    public function getId_pergunta2()
    {
        return $this->Id_pergunta2;
    }
    public function getId_pergunta3()
    {
        return $this->Id_pergunta3;
    }
    public function getId_pergunta4()
    {
        return $this->Id_pergunta4;
    }
    public function getId_pergunta5()
    {
        return $this->Id_pergunta5;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function setId_pergunta1(int $Id_pergunta1)
    {
        $this->Id_pergunta1 = $Id_pergunta1;
    }
    public function setId_pergunta2(int $Id_pergunta2)
    {
        $this->Id_pergunta2 = $Id_pergunta2;
    }
    public function setId_pergunta3(int $Id_pergunta3)
    {
        $this->Id_pergunta3 = $Id_pergunta3;
    }
    public function setId_pergunta4(int $Id_pergunta4)
    {
        $this->Id_pergunta4 = $Id_pergunta4;
    }
    public function setId_pergunta5(int $Id_pergunta5)
    {
        $this->Id_pergunta5 = $Id_pergunta5;
    }
    public static function cadastrar_jogo(int $Id_pergunta1, int $Id_pergunta2, int $Id_pergunta3, int $Id_pergunta4, int $Id_pergunta5)
    {
        $query = "INSERT INTO jogo (\"pergunta1_id\",\"pergunta2_id\",\"pergunta3_id\",\"pergunta4_id\",\"pergunta5_id\") 
                      VALUES ($1, $2, $3, $4, $5) RETURNING id";

        $resultado = pg_query_params(self::$conn, $query, array($Id_pergunta1, $Id_pergunta2, $Id_pergunta3, $Id_pergunta4, $Id_pergunta5));

        if ($resultado) {
            $linha = pg_fetch_row($resultado);
            $jogo = new Jogo($linha[0], $Id_pergunta1, $Id_pergunta2, $Id_pergunta3, $Id_pergunta4, $Id_pergunta5);
            return $jogo;
        }
        return null;
    }
    public function perguntas_do_jogo(){
        $query = "SELECT * FROM perguntas WHERE id IN ($1, $2, $3, $4, $5)";
        $resultado = pg_query_params(self::$conn, $query, array($this->Id_pergunta1, $this->Id_pergunta2, $this->Id_pergunta3, $this->Id_pergunta4, $this->Id_pergunta5));
        $perguntas = array();
        while ($linha = pg_fetch_assoc($resultado)) {
            $perguntas[] = new Pergunta($linha["id"], $linha["tipo"], $linha["dificuldade"], $linha["categoria"], $linha["questao"], $linha["correta"], $linha["erradas"]);
        }
        return $perguntas;
    }

}
