<?php
class Usuario
{
    public int $id;
    public string $nome;
    public string $email;
    public static array $usuarios = [];
    public static $conn;

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

    public static function setConn($conn)
    {
        self::$conn = $conn;
    }
    public function objeto_para_array(Usuario $usuario){
        
    }

    public static function cadastrar_usuario(Usuario $usuario){

        pg_insert(self::$conn, 'usuarios', (array) $usuario);
        
        //ver se tem como retornar o id que o banco gerar para salvar no array
    }

}