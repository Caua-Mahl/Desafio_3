<?php

require_once "Conexao/Conn.php";
require_once "Classes/Jogo.php";
require_once "Classes/Pergunta.php";
require_once "Classes/RequisitorCurl.php";
require_once "Classes/Tentativa.php";
require_once "Classes/Usuario.php";
require_once "Controlador/Controlador.php";
require_once "Conexao/Conexao.php";

session_start(); //pra gente armazenar em que questao estamos

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
        var_dump($jogo);
    } else {
        $jogo = $_SESSION['jogo'];
        var_dump($jogo);
    }
    //$tentativa = Tentativa::cadastrar_tentativa($usuario->getToken(),$jogo->getId(), '12', 'safsad', 'safsad', 'safsad', 'safsad', 1);
    $perguntas = $jogo->perguntas_do_jogo();


    if (!isset($_SESSION['indice_pergunta'])) {
        $_SESSION['indice_pergunta'] = 0;
    } // pra começar da pergunta 1 se não tiver nada definido


    // Verificam  se o botão "Avançar" ou "Voltar" foi pressionado
    if (isset($_POST['avançar']) && $_SESSION['indice_pergunta'] < 4) {
        $_SESSION['indice_pergunta']++;
    }
    if (isset($_POST['voltar']) && $_SESSION['indice_pergunta'] > 0) {
        $_SESSION['indice_pergunta']--;
    }


    $pergunta = $perguntas[$_SESSION['indice_pergunta']]; // pega a pergunta de acordo com o indice, o $perguntas é uma array de objetos Pergunta

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



    if ($_SESSION['indice_pergunta'] > 0) { // se nao tiver na primeira pergunta aparece o botão de voltar
        echo "<input type=\"submit\" name=\"voltar\" value=\"Voltar\">";
    }
    if ($_SESSION['indice_pergunta'] == 4) { // se nao tiver na ultima pergunta aparece o botão de avançar se tiver aparece o botão de enviar
        echo "<input type=\"submit\" name=\"enviar\" value=\"Enviar\">";
    } else {
        echo "<input type=\"submit\" name=\"avançar\" value=\"Avançar\">";
    }
    echo "</form>";
}
//$conexao->deletar_dados_tabelas();
$conexao->desconectar();
