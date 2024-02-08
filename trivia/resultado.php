<?php
session_start();

require_once "Conexao/Conn.php";
require_once "Classes/Jogo.php";
require_once "Classes/Pergunta.php";
require_once "Classes/RequisitorCurl.php";
require_once "Classes/Tentativa.php";
require_once "Classes/Usuario.php";
require_once "Controlador/Controlador.php";
require_once "Conexao/Conexao.php";

$conexao = new Conexao("postgres", "5432", "trivia", "postgres", "exemplo");
$conexao->conectar();
Conn::set_conn($conexao->getConn());

if (isset($_SESSION['respostas'])) {
    $_SESSION['respostas'][$_SESSION['indice_pergunta']] = $_POST['resposta'];

    $respostas = $_SESSION['respostas'];
    foreach ($respostas as $indice => $resposta) {
        $indice++;
        echo "Resposta para a pergunta $indice: $resposta <br>";
        echo "Resposta correta = <br><br>";
    }
    $acertos = Tentativa::calcula_acertos($_SESSION['jogo_id'], $_SESSION['respostas']);
    Tentativa::cadastrar_tentativa(
        $_SESSION['usuario_token'],
        $_SESSION['jogo_id'],
        $_SESSION['respostas'][0],
        $_SESSION['respostas'][1],
        $_SESSION['respostas'][2],
        $_SESSION['respostas'][3],
        $_SESSION['respostas'][4],
        $acertos
    );
    echo "<h2> Acertou $acertos de 5 perguntas</h2>";
} else {
    echo "Nenhuma resposta foi encontrada.";
}
unset($_SESSION['respostas']);
$conexao->desconectar();
