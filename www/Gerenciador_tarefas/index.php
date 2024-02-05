<?php

require "Classes/Conexao.php";
require "Classes/Projeto.php";
require "Classes/Tarefa.php";
require "Classes/Usuario.php";
require "Classes/Atribuiçao.php";


$conexao = new Conexao("postgres", "5432", "gerenciador", "postgres", "exemplo");
$conn = $conexao->conectar();

Usuario::setConn($conn); // dentro da classe conexao criar o set conexao e herdar das outras classes

$usuario1 = new Usuario("5", "cauã", 'cauzin@gmail.com');

print_r($usuario1);
Usuario::cadastrar_usuario($usuario1);

//Controlador::cadastrarProjeto("Projeto 1","Descriçao do projeto 1 blablabla")

echo "<pre>";
print_r(Usuario::getUsuarios());


echo"josdihzfpiuhdasf";
$conexao->desconectar();