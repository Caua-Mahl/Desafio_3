<?php
session_start();

if (isset($_SESSION['respostas'])) {
    $respostas = $_SESSION['respostas'];

    foreach ($respostas as $indice => $resposta) {
        echo "Resposta para a pergunta $indice: $resposta <br>";
    }
} else {
    echo "Não respondeu nada.";
}
?>