<?php

require_once "Conexao/Conexao.php";
require_once "Conexao/Conn.php";

require_once "Classes/Jogo.php";
require_once "Classes/Pergunta.php";
require_once "Classes/RequisitorCurl.php";
require_once "Classes/Tentativa.php";
require_once "Classes/Usuario.php";

require_once "Controlador/Controlador.php";

$conexao = new Conexao("postgres", "5432", "trivia", "postgres", "exemplo");
$conexao->conectar();
Conn::set_conn($conexao->getConn());

$usuario   = Usuario::cadastrar_usuario("Gustavo");
$jogo      = Controlador::jogar($usuario->getToken());
$tentativa = Tentativa::cadastrar_tentativa($usuario->getToken(),$jogo->getId(), '12', 'safsad', 'safsad', 'safsad', 'safsad', 1);

$conexao->deletar_dados_tabelas();
$conexao->desconectar();