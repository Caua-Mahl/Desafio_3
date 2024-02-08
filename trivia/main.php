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

function jogar_jogo()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['nome'])) {
            $usuario = Usuario::cadastrar_usuario($_POST['nome']);
            $_SESSION['usuario'] = $usuario;
            $jogo = Controlador::jogar();
            $_SESSION['jogo'] = $jogo;
            $_SESSION['indice_pergunta'] = 0;

        } else {
            $jogo = $_SESSION['jogo'];
        }
        if (isset($_POST['resposta'])) {
            $_SESSION['respostas'][$_SESSION['indice_pergunta']] = $_POST['resposta'];
            echo "Resposta para a pergunta " . $_SESSION['indice_pergunta'] . ": " . $_POST['resposta'] . "<br>";
            echo "<br>";
            echo "<pre>";
            var_dump($_SESSION['respostas'][$_SESSION['indice_pergunta']]);
            echo "<br>";
            echo "<br>";
            echo "<pre>";
            var_dump($_SESSION['respostas']);
            echo "<br>";

        }
        if (isset($_POST['voltar']) && $_SESSION['indice_pergunta'] > 0) {
            $_SESSION['indice_pergunta']--;
        }
        if (isset($_POST['avançar']) && $_SESSION['indice_pergunta'] < 4) {
            $_SESSION['indice_pergunta']++;
        }
        if (isset($_POST['enviar']) && $_SESSION['indice_pergunta'] == 4) {
            $_SESSION['respostas'][$_SESSION['indice_pergunta']] = $_POST['resposta'];

            header("Location: resultados.php");
            exit();
        }
        if (isset($jogo->perguntas_do_jogo()[$_SESSION['indice_pergunta']])) {
            if ($_SESSION['indice_pergunta'] < 4) {
                $action = 'main.php';
            } else {
                $action = 'resultado.php';
            }
            $pergunta = $jogo->perguntas_do_jogo()[$_SESSION['indice_pergunta']];
            echo "<h2>" . $pergunta->getQuestao() . "</h2>";
            echo "<form action=\"$action\" method=\"post\">";
            echo "<input type=\"radio\" name=\"resposta\" value=\"" . $pergunta->getCorreta() . "\">" . $pergunta->getCorreta() . "<br>";

            if ($pergunta->getTipo() == "multiple") {
                $erradas = explode(", ", $pergunta->getErradas());
                foreach ($erradas as $errada) {
                    echo "<input type=\"radio\" name=\"resposta\" value=\"$errada\">$errada<br>";
                }
            } else {
                echo "<input type=\"radio\" name=\"resposta\" value=\"" . $pergunta->getErradas() . "\">" . $pergunta->getErradas() . "<br>";
            }
            if ($_SESSION['indice_pergunta'] > 0) {
                echo "<input type=\"submit\" name=\"voltar\" value=\"Voltar\">";
            }
            if ($_SESSION['indice_pergunta'] < 4) {
                echo "<input type=\"submit\" name=\"avançar\" value=\"Avançar\">";
            }
            if ($_SESSION['indice_pergunta'] == 4) {
                echo "<input type=\"submit\" name=\"enviar\" value=\"Enviar\">";
            }
            echo "</form>";
        }
    }
}
jogar_jogo();
//$conexao->deletar_dados_tabelas();
$conexao->desconectar();