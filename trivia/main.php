<?php

require_once "Conexao/Conn.php";
require_once "Classes/Jogo.php";
require_once "Classes/Pergunta.php";
require_once "Classes/RequisitorCurl.php";
require_once "Classes/Tentativa.php";
require_once "Classes/Usuario.php";
require_once "Controlador/Controlador.php";
require_once "Conexao/Conexao.php";

session_start();

$conexao = new Conexao("postgres", "5432", "trivia", "postgres", "exemplo");
$conexao->conectar();
// $conexao->deletar_dados_tabelas();
// $conexao->desconectar();
Conn::set_conn($conexao->getConn());
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome'])) {
        $usuario = Usuario::cadastrar_usuario($_POST['nome']);
        $_SESSION['usuario'] = $usuario;
    }
    var_dump($_SESSION['usuario']);
    if (!isset($_SESSION['jogo'])) {
        $jogo = Controlador::jogar($usuario->getToken());
        $_SESSION['jogo'] = $jogo;
    } else {
        $jogo = $_SESSION['jogo'];
    }
    //$tentativa = Tentativa::cadastrar_tentativa($usuario->getToken(),$jogo->getId(), '12', 'safsad', 'safsad', 'safsad', 'safsad', 1);
    $perguntas = $jogo->perguntas_do_jogo();


    if (!isset($_SESSION['indice_pergunta'])) {
        $_SESSION['indice_pergunta'] = 0;
    }

    if (isset($_POST['avançar']) && $_SESSION['indice_pergunta'] < 4) {
        $_SESSION['indice_pergunta']++;
    }
    if (isset($_POST['voltar']) && $_SESSION['indice_pergunta'] > 0) {
        $_SESSION['indice_pergunta']--;
    }


    $pergunta = $perguntas[$_SESSION['indice_pergunta']];

    echo "<h2>" . $pergunta->getQuestao() . "</h2>";
    echo "<form action=\"\" method=\"post\">";
    echo "<input type=\"radio\" name=\"resposta\" value=\"" . $pergunta->getCorreta() . "\">" . $pergunta->getCorreta() . "<br>";
    if ($pergunta->getTipo() == "multiple") {
        $erradas = explode(", ", $pergunta->getErradas());
        for ($j = 0; $j < 3; $j++) {
            echo "<input type=\"radio\" name=\"resposta\" value=\"" . $erradas[$j] . "\">" . $erradas[$j] . "<br>";
        }
    } else {
        echo "<input type=\"radio\" name=\"resposta\" value=\"" . $pergunta->getErradas() . "\">" . $pergunta->getErradas() . "<br>";
    }

    if ($_SESSION['indice_pergunta'] > 0) {
        echo "<input type=\"submit\" name=\"voltar\" value=\"Voltar\">";
    }
    if ($_SESSION['indice_pergunta'] == 4) {
        echo "</form>";
        echo "<form action=\"resultado.php\" method=\"post\">";
        echo "<input type=\"submit\" name=\"enviar\" value=\"Enviar\">";
    } else {
        echo "<input type=\"submit\" name=\"avançar\" value=\"Avançar\">";
    }
    echo "</form>";
}
//$conexao->deletar_dados_tabelas();
$conexao->desconectar();
