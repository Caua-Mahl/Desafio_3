<?php 
class Usuario{
    private int    $id;
    private string $nome;
    private string $email;
    private        $conn;
    private static array $usuarios = [];

    public function __construct(int $id, string $nome, string $email, $conn){
        $this->id    = $id;
        $this->nome  = $nome;
        $this->email = $email;
        $this->conn  = $conn;
    }

    public static function cadastrar(string $nome,string $email, $conn){
        $sql = "INSERT INTO usuarios (nome, email) 
        VALUES ('$nome', '$email') RETURNING id, nome, email;";

        $resultado = pg_query($conn, $sql); 

        if ($resultado === false) {
            die("Error: " . pg_last_error());
        }

        return pg_fetch_array($resultado);
    }

    public function getId(): int{
        return $this->id;
    }
    public function getNome(): string{
        return $this->nome;
    }
    public function getEmail(): string{
        return $this->email;
    }
    public function getConn(){
        return $this->conn;
    }
    public static function getUsuarios(): array{
        return self::$usuarios;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }
    public function setNome(string $nome): void{
        $this->nome = $nome;
    }
    public function setEmail(string $email): void{
        $this->email = $email;
    }
    public function setConn($conn): void{
        $this->conn = $conn;
    }
    public static function setUsuarios(object $usuarios): void{
        self::$usuarios[] = $usuarios;

}

}