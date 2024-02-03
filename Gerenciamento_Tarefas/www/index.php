<?php 

require "Classes/Conexao.php";
require "Classes/Projeto.php";
require "Classes/Tarefa.php";
require "Classes/Usuario.php";
require "Classes/Atribuiçao.php";


$conexao = new Conexao("postgres", "5432","postgres","postgres", "exemplo");
$conexao->conectar();
$conn= $conexao->getConn();

//nossa lógica

$conexao->desconectar();