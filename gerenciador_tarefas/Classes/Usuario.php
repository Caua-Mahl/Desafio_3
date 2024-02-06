<?php

require_once "Conn.php";

class Usuario extends Conn{
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

    public static function getUsuarios(): array
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

    public static function cadastrar_usuario(string $nome, string $email){
        $query     = "INSERT INTO usuarios (\"nome\",\"email\") 
                      VALUES ($1, $2) RETURNING id";
        $resultado = pg_query_params(self::$conn, $query, array($nome, $email));
        
        if ($resultado) {
            $linha            = pg_fetch_row($resultado);
            $usuario          = new Usuario($linha[0], $nome, $email);
            self::$usuarios[] = $usuario;
        }
    }

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