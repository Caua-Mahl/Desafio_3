<?php

require "Classes/Conexao.php";
require "Classes/Projeto.php";
require "Classes/Tarefa.php";
require "Classes/Usuario.php";
require "Classes/Atribuicao.php";
require_once "Classes/Conn.php";

$conexao = new Conexao("postgres", "5432", "gerenciador", "postgres", "exemplo");
$conn    = $conexao->conectar();

Conn::set_conn($conn);

Usuario::cadastrar_usuario("caua",    'cauzin@gmail.com');
Usuario::cadastrar_usuario("gustavo", 'mottinha@gmail.com');

$usuarios = (Usuario::getUsuarios()); 

Usuario::remover_usuario($usuarios[1]);
$usuarios[0]->setNome('Cauazao');
Usuario::atualizar_usuario_no_banco($usuarios[0]);

Projeto::cadastrar_projeto( "teste 1", "testando projeto", "2023-02-10", "2024-03-11");
Projeto::cadastrar_projeto( "teste 2", "testando projeto", "2023-02-10", "2024-03-11");

$projetos = Projeto::getProjetos();
Projeto::remover_projeto($projetos[1]);
$projetos[0]->setNome("Projeto verão");
Projeto::atualizar_projeto_no_banco($projetos[0]);

$projetoid = $projetos[0]->getId();
Tarefa::cadastrar_tarefa('tarefa teste', $projetoid, "2023-02-10", "2024-03-11");
Tarefa::cadastrar_tarefa('teste tarefa', $projetoid, "2023-08-11", "2024-12-19");

$tarefas = Tarefa::getTarefas();
Tarefa::remover_tarefa($tarefas[1]);
$tarefas[0]->setDescricao("Tarefa que sobrou");
Tarefa::atualizar_tarefa_no_banco($tarefas[0]);

$resultados = Usuario::listar_usuarios_do_banco();
while ($usuarios_banco = pg_fetch_assoc($resultados)) {
   echo "<br>ID: {$usuarios_banco['id']}<br> Nome: {$usuarios_banco['nome']}<br>Email: {$usuarios_banco['email']}";
}

echo "<br>";
$resultados = Projeto::listar_projetos_do_banco();
while ($projetos_banco = pg_fetch_assoc($resultados)) {
    echo "<br>ID: {$projetos_banco['id']}<br> Nome: {$projetos_banco['nome']}<br>Descrição: {$projetos_banco['descricao']}<br>Data Inicio: {$projetos_banco['data_inicio']}<br>Data Fim: {$projetos_banco['data_fim']}";
}

echo "<br>";

$resultados = Tarefa::listar_tarefas_do_banco();
while ($tarefas_banco = pg_fetch_assoc($resultados)) {
    echo "<br>ID: {$tarefas_banco['id']}<br> Descrição: {$tarefas_banco['descricao']}<br>Projeto ID: {$tarefas_banco['projeto_id']}<br>Data Inicio: {$tarefas_banco['data_inicio']}<br>Data Fim: {$tarefas_banco['data_fim']}";
}

$conexao->DeletarTabelas(); 
$conexao->desconectar();

//testes atribuições
//$atribuicao1 = new Atribuicao(1, 1, 1, "2023-02-10");
//$atribuicao2 = new Atribuicao(2, 2, 2, "2023-08-11");

//Atribuicao::cadastrar_atribuicao($atribuicao1);
//Atribuicao::cadastrar_atribuicao($atribuicao2);

//Atribuicao::remover_atribuicao($atribuicao1);
//$atribuicao1->setDataAtribuicao("2024-09-09");
//Atribuicao::atualizar_atribuicao_no_banco($atribuicao1);