<?php 

require 'Classes/Conexao.php';

$conexao = new Conexao("postgres", "5432","ge","ge", "exemplo");
$conexao->conectar();
$conn    = $conexao->getConn();
$conexao->desconectar();