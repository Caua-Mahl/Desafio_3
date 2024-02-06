<?php

require_once "Conexao/Conn.php";
class Pergunta extends Conn
{
    private int $id;
    private string $tipo;
    private string $dificuldade;
    private string $categoria;
    private string $questao;
    private string $correta;
    private string $erradas;

    public function __construct(int $id, string $tipo, string $dificuldade, string $categoria, string $questao, string $correta, string $erradas)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->dificuldade = $dificuldade;
        $this->categoria = $categoria;
        $this->questao = $questao;
        $this->correta = $correta;
        $this->erradas = $erradas;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getDificuldade()
    {
        return $this->dificuldade;
    }
    public function getCategoria()
    {
        return $this->categoria;
    }
    public function getQuestao()
    {
        return $this->questao;
    }
    public function getCorreta()
    {
        return $this->correta;
    }
    public function getErradas()
    {
        return $this->erradas;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function setDificuldade(string $dificuldade)
    {
        $this->dificuldade = $dificuldade;
    }
    public function setCategoria(string $categoria)
    {
        $this->categoria = $categoria;
    }
    public function setQuestao(string $questao)
    {
        $this->questao = $questao;
    }
    public function setCorreta(string $correta)
    {
        $this->correta = $correta;
    }
    public function setErrada(string $erradas)
    {
        $this->erradas = $erradas;
    }
    public function setTipo(string $tipo)
    {
        $this->tipo = $tipo;
    }
    public static function cadastrar_pergunta(string $tipo, string $dificuldade, string $categoria, string $questao, string $correta, string $errada)
    {
        $query = "INSERT INTO perguntas (\"tipo\",\"dificuldade\",\"categoria\",\"questao\",\"correta\",\"erradas\") 
                      VALUES ($1, $2, $3, $4, $5, $6) RETURNING id";
        $resultado = pg_query_params(self::$conn, $query, array($tipo, $dificuldade, $categoria, $questao, $correta, $errada));

        if ($resultado) {
            $linha = pg_fetch_row($resultado);
            $pergunta = new Pergunta($linha[0], $tipo, $dificuldade, $categoria, $questao, $correta, $errada);
        }
        return $pergunta;
    }
}