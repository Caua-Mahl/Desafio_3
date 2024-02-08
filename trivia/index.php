<?php
if (isset($_SESSION['usuario'])) {
    session_unset();
    session_destroy();
    unset($_SESSION['indice_pergunta']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
        <title>Trivia</title>
    </head>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Bem vindo ao Trivia</h1>
        </div>
        <div class="form">
            <h2>Qual o seu nome?</h2>
            <form action="main.php" method="post">
                <input type="text" name="nome" value="">
                <input class="button" type="submit" value="Jogar">
            </form>
        </div>
        <div class="footer">
            <p>Desenvolvido por Cauã e Gustavo </p>
        </div>
    </div>
</body>

</html>