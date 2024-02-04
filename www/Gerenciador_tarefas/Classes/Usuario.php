<?php 
class Usuario{
    private int    $id;
    private string $nome;
    private string $email;
    private        $conn;

    public function __construct(string $nome, string $email, $conn){
        $this->nome  = $nome;
        $this->email = $email;
        $this->conn  = $conn;
    }

    public function cadastrar(){
        $sql = "INSERT INTO usuarios (nome, email) 
        VALUES ('$this->nome', '$this->email') RETURNING id";

        $resultado = pg_query($this->conn, $sql); 

        if ($resultado === false) {
            die("Error: " . pg_last_error());
        }

        $ultimoId = pg_fetch_array($resultado);
        $this->id = $ultimoId["id"];   
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
    public function setId(int $id): void{
        $this->id = $id;
    }
    public function setNome(string $nome): void{
        $this->nome = $nome;
    }
    public function setEmail(string $email): void{
        $this->email = $email;
    }
}