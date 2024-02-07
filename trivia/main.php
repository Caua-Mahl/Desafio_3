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
Conn::set_conn($conexao->getConn());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome'])) {
        $usuario = Usuario::cadastrar_usuario($_POST['nome']);
        $_SESSION['usuario'] = $usuario;
        $jogo = Controlador::jogar();
        $_SESSION['jogo'] = $jogo;
        $_SESSION['indice_pergunta'] = 0; // Adicionado para garantir que o índice comece em 0
    } else {
        $jogo = $_SESSION['jogo'];
    }

    if (isset($_POST['avançar']) && $_SESSION['indice_pergunta'] < 4) {
        $_SESSION['indice_pergunta']++;
    }
    if (isset($_POST['voltar']) && $_SESSION['indice_pergunta'] > 0) {
        $_SESSION['indice_pergunta']--;
    }
    if (isset($_POST['enviar']) && $_SESSION['indice_pergunta'] == 4) {
        header("Location: resultados.php");
        exit();
    }

    if (isset($jogo->perguntas_do_jogo()[$_SESSION['indice_pergunta']])) {
        $pergunta = $jogo->perguntas_do_jogo()[$_SESSION['indice_pergunta']];
        echo "<h2>" . $pergunta->getQuestao() . "</h2>";
        echo "<form action=\"main.php\" method=\"post\">"; // Corrigido para enviar os dados para main.php
        echo "<input type=\"radio\" name=\"resposta\" value=\"" . $pergunta->getCorreta() . "\">" . $pergunta->getCorreta() . "<br>";
        if ($pergunta->getTipo() == "multiple") {
            $erradas = explode(", ", $pergunta->getErradas());
            foreach ($erradas as $errada) {
                echo "<input type=\"radio\" name=\"resposta\" value=\"$errada\">$errada<br>"; // Corrigido o loop foreach
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
    } else {
        throw new Exception("Problema na lógica das perguntas.");
    }
}
//$conexao->deletar_dados_tabelas();
$conexao->desconectar();