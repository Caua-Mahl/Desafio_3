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


function verificar_respostas()
{
    if (isset($_SESSION['respostas'])) {
        $_SESSION['respostas'][$_SESSION['indice_pergunta']] = $_POST['resposta'];
        $perguntas = $_SESSION['perguntas'];
        $corretas  = $_SESSION['corretas'];
        $respostas = $_SESSION['respostas'];
        $acertos   = 0;

        foreach ($respostas as $indice => $resposta) {
            if (substr($resposta,1,-1) == $corretas[$indice]) {
                $acertos++;
            }
        }

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
        echo "<h2> Acertou $acertos de 5 perguntas</h2> <br>";

        foreach ($respostas as $indice => $resposta) {
            $indice++;
            echo "Pergunta $indice: " . $perguntas[$indice-1]. "<br>";
            echo "Resposta marcada: $resposta <br>";
            echo "Resposta correta: " . $corretas[$indice-1] . "<br><br>";
        }
    } else {
        echo "Nenhuma resposta foi encontrada.";
    }
    unset($_SESSION['respostas']);
}
// $conexao->desconectar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
    <title>Trivia - Resultado</title>
</head>

<body>
    <div class="container-resultado">
        <div class="form">
            <?php verificar_respostas() ?>

            <form action="index.php" method="get">
                <input class="button-main" type="submit" value="Jogar Novamente">
            </form>
            <form action="https://youtu.be/dQw4w9WgXcQ?si=OJyCn7-IFrrXkeEw" method="get">
                <input class="button-main" type="submit" value="Sair">
            </form>

        </div>
    </div>
</body>

</html>