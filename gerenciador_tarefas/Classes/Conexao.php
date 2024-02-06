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

    public function get_conn()
    {
        return $this->conn;
    }
    public function get_host(): string
    {
        return $this->host;
    }
    public function get_port(): string
    {
        return $this->port;
    }
    public function get_db_name(): string
    {
        return $this->dbname;
    }
    public function get_user(): string
    {
        return $this->user;
    }
    public function get_password(): string
    {
        return $this->password;
    }
    public function get_infos_string(): string
    {
        return $this->infos_string;
    }
    public function set_host(string $host): void
    {
        $this->host = $host;
    }
    public function set_port(string $port): void
    {
        $this->port = $port;
    }
    public function set_db_name(string $dbname): void
    {
        $this->dbname = $dbname;
    }
    public function set_user(string $user): void
    {
        $this->user = $user;
    }
    public function set_password(string $password): void
    {
        $this->password = $password;
    }
    public function set_infos_string(string $infos_string): void
    {
        $this->infos_string = $infos_string;
    }


    public function conectar()
    {
        $this->conn = pg_connect($this->infos_string) or die("Nao foi possivel conectar ao Banco de Dados  <br><br>");
        echo "Conexão bem sucedida  <br><br>";
        return $this->conn;
    }

    public function deletar_tabelas(): void
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
        $comando = "SELECT setval('atribuicoes_id_seq', coalesce(max(id), 1), false) FROM usuarios
        UNION ALL
        SELECT setval('atribuicoes_id_seq', coalesce(max(id), 1), false) FROM tarefas
        UNION ALL
        SELECT setval('atribuicoes_id_seq', coalesce(max(id), 1), false) FROM atribuicoes
        UNION ALL
        SELECT setval('atribuicoes_id_seq', coalesce(max(id), 1), false) FROM projetos;
        ";

        $comando_zerar_ids_usuarios = "SELECT setval('usuarios_id_seq', coalesce(max(id), 1), false) FROM usuarios";
        $comando_zerar_ids_tarefas = "SELECT setval('tarefas_id_seq', coalesce(max(id), 1), false) FROM tarefas";
        $comando_zerar_ids_atribuicoes = "SELECT setval('atribuicoes_id_seq', coalesce(max(id), 1), false) FROM atribuicoes";
        $comando_zerar_ids_projetos = "SELECT setval('projetos_id_seq', coalesce(max(id), 1), false) FROM projetos";
        pg_query($this->conn, $comando_zerar_ids_atribuicoes);
        pg_query($this->conn, $comando_zerar_ids_usuarios);
        pg_query($this->conn, $comando_zerar_ids_tarefas);
        pg_query($this->conn, $comando_zerar_ids_projetos);

    }

    public function desconectar(): void
    {
        pg_close($this->conn) or die("Nao foi possivel desconectar ao Banco de Dados  <br><br>");
        echo "<br> Desconexão bem sucedida";
    }
}