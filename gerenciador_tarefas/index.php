<?php

require "Classes/Conexao.php";
require "Classes/Projeto.php";
require "Classes/Tarefa.php";
require "Classes/Usuario.php";
require "Classes/Atribuicao.php";

$conexao = new Conexao("postgres", "5432", "gerenciador", "postgres", "exemplo");
$conn = $conexao->conectar();

//seta a conexão padrao para todas as classes
Atribuicao::set_conn($conn);
Projeto::set_conn($conn);
Tarefa::set_conn($conn);
Usuario::set_conn($conn);

$usuario1 = new Usuario("1", "caua", 'cauzin@gmail.com');
$usuario2 = new Usuario("2", "gustavo", 'mottinha@gmail.com');

//testes usuarios
Usuario::cadastrar_usuario($usuario1);
Usuario::cadastrar_usuario($usuario2);
//Usuario::remover_usuario($usuario2);

$usuario1->setNome('asdfasdfsdfads');
Usuario::atualizar_usuario_no_banco($usuario1);

$projeto1 = new Projeto(1, "teste", "testando projeto", "2023-02-10", "2024-03-11");
$projeto2 = new Projeto(2, "teste 2 2 2 2", "testando projeto2 2 2 2", "2024-11-10", "2024-12-25");

//testes projetos
Projeto::cadastrar_projeto($projeto1);
Projeto::cadastrar_projeto($projeto2);
//Projeto::remover_projeto($projeto1);

$projeto2->setNome("sdafsad");
Projeto::atualizar_projeto_no_banco($projeto2);

//testes tarefas
$tarefa1 = new Tarefa(1, 'tarefa teste', 1, "2023-02-10", "2024-03-11");
$tarefa2 = new Tarefa(2, 'testnado tarefas', 2, "2023-08-11", "2024-12-19");

Tarefa::cadastrar_tarefa($tarefa1);
Tarefa::cadastrar_tarefa($tarefa2);
//Tarefa::remover_tarefa($tarefa2);

$tarefa2->setDescricao("HAHAHAHAH");
Tarefa::atualizar_tarefa_no_banco($tarefa2);

//testes atribuições
$atribuicao1 = new Atribuicao(1, 1, 1, "2023-02-10");
$atribuicao2 = new Atribuicao(2, 2, 2, "2023-08-11");

Atribuicao::cadastrar_atribuicao($atribuicao1);
Atribuicao::cadastrar_atribuicao($atribuicao2);

//Atribuicao::remover_atribuicao($atribuicao1);
$atribuicao1->setDataAtribuicao("2024-09-09");
Atribuicao::atualizar_atribuicao_no_banco($atribuicao1);




$conexao->desconectar();

//MODELO PARA PRINT, VAI SER USADO DEPOIS PQ SE NAO POLUI DEMAIS O INDEX, MAS NAO TEM MISTERIO, FUNCIONA DE BOA
// $resultados = Usuario::listar_usuarios_do_banco();
// while ($usuarios_banco = pg_fetch_assoc($resultados)) {
//     echo "<br>ID: {$usuarios_banco['id']}<br> Nome: {$usuarios_banco['nome']}<br>Email: {$usuarios_banco['email']}";
// }