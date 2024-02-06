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
$jogo1 = Jogo::cadastrar_jogo(1, 2, 3, 4, 5);
$tentativa = Tentativa::cadastrar_tenativa('9e8123d1e43ac8004a5aeeb855b690083f25aed94e50b65128db447eb699727d', 1, '12', 'safsad', 'safsad', 'safsad', 'safsad', 1);
=======


//$conexao->deletar_dados_tabelas();
$conexao->desconectar();