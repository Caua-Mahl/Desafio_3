<?php
session_start();

if (isset($_SESSION['respostas'])) {
    $_SESSION['respostas'][$_SESSION['indice_pergunta']] = $_POST['resposta'];

    $respostas = $_SESSION['respostas'];
    foreach ($respostas as $indice => $resposta) {
        $indice++;
        echo "Resposta para a pergunta $indice: $resposta <br>";
        //$indice--;
    }
} else {
    echo "Nenhuma resposta foi encontrada.";
}
unset($_SESSION['respostas']);