<?php

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

$usuario = Usuario::cadastrar_usuario("nome");
$jogo = Controlador::jogar();
//$tentativa = Tentativa::cadastrar_tentativa($usuario->getToken(),$jogo->getId(), '12', 'safsad', 'safsad', 'safsad', 'safsad', 1);
$perguntas = $jogo->perguntas_do_jogo();
for ($i = 0; $i < sizeof($perguntas); $i++) {
    echo "<h2>" . $perguntas[$i]->getQuestao() . "</h2>";
    echo "<input type=\"radio\" name=\"resposta\" value=\"" . $perguntas[$i]->getCorreta() . "\">" . $perguntas[$i]->getCorreta() . "<br>";

    if ($perguntas[$i]->getTipo() == "multiple") {
        $erradas = explode(", ", $perguntas[$i]->getErradas());
        for ($j = 0; $j < 3; $j++) {
            echo "<input type=\"radio\" name=\"resposta\" value=\"" . $erradas[$j] . "\">" . $erradas[$j] . "<br>";
        }
    } else {
        echo "<input type=\"radio\" name=\"resposta\" value=\"" . $perguntas[$i]->getErradas() . "\">" . $perguntas[$i]->getErradas() . "<br>";
    }
}

//session_unset();
//session_destroy();
//$conexao->deletar_dados_tabelas();
$conexao->desconectar();