<?php 

require_once "Classes/Conexao.php";

$conexao = new Conexao("postgres", "5432","postgres","postgres", "exemplo");
$conexao->conectar();
$conn= $conexao->getConn();

//nossa lógica

$conexao->desconectar();