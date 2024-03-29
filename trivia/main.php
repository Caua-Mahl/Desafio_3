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

function jogar_jogo($conexao)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['nome'])) {
            $usuario = Usuario::cadastrar_usuario($_POST['nome']);
            $_SESSION['usuario_token'] = $usuario->getToken();
            $_SESSION['usuario'] = $usuario;
            $jogo = Controlador::jogar();
            $_SESSION['jogo_id'] = $jogo->getId();
            $_SESSION['jogo'] = $jogo;
            $_SESSION['indice_pergunta'] = 0;
        } else {
            $jogo = $_SESSION['jogo'];
        }
        if (isset($_POST['resposta'])) {
            $_SESSION['respostas'][$_SESSION['indice_pergunta']] = $_POST['resposta'];
        }
        if (isset($_POST['voltar']) && $_SESSION['indice_pergunta'] > 0) {
            $_SESSION['indice_pergunta']--;
        }
        if (isset($_POST['avançar']) && $_SESSION['indice_pergunta'] < 4) {
            $_SESSION['indice_pergunta']++;
        }
        if (isset($_POST['enviar']) && $_SESSION['indice_pergunta'] == 4) {
            $conexao->desconectar();
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

            $array_perguntas = explode(", ", $pergunta->getErradas());
            $array_perguntas[] = $pergunta->getCorreta();
            shuffle($array_perguntas);

            echo "<h2>" . $pergunta->getQuestao() . "</h2>";
            for ($i = 0; $i < sizeof($array_perguntas); $i++) {
                echo "<form action=\"$action\" method=\"post\">";
                echo "<input type=\"radio\" name=\"resposta\" value=\"" . $array_perguntas[$i] . "\">" . $array_perguntas[$i] . "<br>";

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

//$conexao->deletar_dados_tabelas();
//$conexao->desconectar();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
    <title>Trivia</title>
</head>

<body>
    <div class="container">
        <div class="form">
            <?php jogar_jogo($conexao) ?>
        </div>
    </div>
</body>

</html>