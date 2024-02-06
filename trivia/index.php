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

#pegando 5 perguntas da api
Controlador::get_perguntas();
Usuario::cadastrar_usuario("Gustavo");

$conexao->deletar_dados_tabelas();
$conexao->desconectar();