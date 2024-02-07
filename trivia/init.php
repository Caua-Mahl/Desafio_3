<?php

require_once "Conexao/Conn.php";
require_once "Classes/Jogo.php";
require_once "Classes/Pergunta.php";
require_once "Classes/RequisitorCurl.php";
require_once "Classes/Tentativa.php";
require_once "Classes/Usuario.php";
require_once "Controlador/Controlador.php";
require_once "Conexao/Conexao.php";
require_once "Game.php";

session_start(); //pra gente armazenar em que questao estamos

$conexao = new Conexao("postgres", "5432", "trivia", "postgres", "exemplo");
$conexao->conectar();
Conn::set_conn($conexao->getConn());
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['usuario'])) {
        $usuario = Usuario::cadastrar_usuario($_POST["nome"]);
        $_SESSION['usuario'] = $usuario;
    } else {
        $usuario = ($_SESSION['usuario']);
    }
    $jogo      = Controlador::jogar($usuario->getToken());
  //$tentativa = Tentativa::cadastrar_tentativa($usuario->getToken(),$jogo->getId(), '12', 'safsad', 'safsad', 'safsad', 'safsad', 1);
    Game::jogo($jogo->perguntas_do_jogo());
}
//$conexao->deletar_dados_tabelas();
$conexao->desconectar();