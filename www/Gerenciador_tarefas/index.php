<?php 

require "Classes/Conexao.php";
require "Classes/Projeto.php";
require "Classes/Tarefa.php";
require "Classes/Usuario.php";
require "Classes/Atribuiçao.php";
require "Controlador/Controlador.php";


$conexao = new Conexao("postgres", "5432","gerenciador","postgres", "exemplo");
$conexao->conectar();
$conn= $conexao->getConn();

// controlador cuida da criação dos objetos e da adição ao db  com suas funções estáticas
Controlador::setConn($conn); // settar variavel estatica de conexao
Controlador::cadastrarUsuario("Cauã", "caua@gmail.com");
Controlador::cadastrarUsuario("Gustavo", "gustavo@gmail.com");

echo "<pre>";
print_r(Usuario::getUsuarios());

$conexao->desconectar();