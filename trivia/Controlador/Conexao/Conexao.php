<?php
class Conexao
{
    private string $host;
    private string $port;
    private string $dbname;
    private string $user;
    private string $password;
    private string $infos_string;
    private $conn;

    public function __construct(string $host, string $port, string $dbname, string $user, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $this->infos_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
    }

    public function getConn()
    {
        return $this->conn;
    }
    public function getHost(): string
    {
        return $this->host;
    }
    public function getPort(): string
    {
        return $this->port;
    }
    public function getDbname(): string
    {
        return $this->dbname;
    }
    public function getUser(): string
    {
        return $this->user;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getInfosString(): string
    {
        return $this->infos_string;
    }
    public function setHost(string $host): void
    {
        $this->host = $host;
    }
    public function setPort(string $port): void
    {
        $this->port = $port;
    }
    public function setDbname(string $dbname): void
    {
        $this->dbname = $dbname;
    }
    public function setUser(string $user): void
    {
        $this->user = $user;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setInfosString(string $infos_string): void
    {
        $this->infos_string = $infos_string;
    }

    public function conectar(): void
    {
        $this->conn = pg_connect($this->infos_string) or die("Nao foi possivel conectar ao Banco de Dados  <br><br>");
    }

    public function desconectar(): void
    {
        pg_close($this->conn) or die("Nao foi possivel desconectar do Banco de Dados  <br><br>");
    }
    public function deletar_dados_tabelas(): void
    {
        $resultado = pg_query($this->conn, "SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
        if (!$resultado) {
            echo "An error occurred.\n";
            exit;
        }
        while ($linha = pg_fetch_row($resultado)) {
            $table = $linha[0];
            pg_query($this->conn, "TRUNCATE TABLE $table CASCADE");
        }

        $comando_zerar_ids_perguntas = "SELECT setval('perguntas_id_seq', coalesce(max(id), 1), false) FROM perguntas";
        $comando_zerar_ids_jogo = "SELECT setval('jogo_id_seq', coalesce(max(id), 1), false) FROM jogo";
        pg_query($this->conn, $comando_zerar_ids_jogo);
        pg_query($this->conn, $comando_zerar_ids_perguntas);

    }
}