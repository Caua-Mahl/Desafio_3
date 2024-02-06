<?php

require "Classes/Conexao.php";
require "Classes/Projeto.php";
require "Classes/Tarefa.php";
require "Classes/Usuario.php";
require "Classes/Atribuicao.php";
require_once "Classes/Conn.php";

$conexao = new Conexao("postgres", "5432", "gerenciador", "postgres", "exemplo");
$conn = $conexao->conectar();

Conn::set_conn($conn);

//TESTES USUARIO
$usuario1 = Usuario::cadastrar_usuario("caua", 'cauzin@gmail.com');
$usuario2 = Usuario::cadastrar_usuario("gustavo", 'mottinha@gmail.com');
//Usuario::remover_usuario($usuarios1);
$usuario2->setNome('HSDAHSHDSGAF');
Usuario::atualizar_usuario_no_banco($usuario2);

//TESTES PROJETOS
$projeto1 = Projeto::cadastrar_projeto("teste 1", "testando projeto", "2023-02-10", "2024-03-11");
$projeto2 = Projeto::cadastrar_projeto("teste 2", "testando projeto", "2023-02-10", "2024-03-11");
//Projeto::remover_projeto($projeto1);
$projeto2->setNome("Projeto verão");
Projeto::atualizar_projeto_no_banco($projetos2);

//TESTES TAREFAS
$tarefa1 = Tarefa::cadastrar_tarefa('tarefa teste', $projeto1->getId(), "2023-02-10", "2024-03-11");
$tarefa2 = Tarefa::cadastrar_tarefa('teste tarefa', $projeto2->getId(), "2023-08-11", "2024-12-19");
Tarefa::remover_tarefa($tarefas1);
$tarefa2->setDescricao("Tarefa que sobrou");
Tarefa::atualizar_tarefa_no_banco($tarefa2);

//TESTES ATRIBUICOES
$atribuicao1 = Atribuicao::cadastrar_atribuicao($usuario1->getId(), $tarefa1->getId(), "2024-09-25");
$atribuicao2 = Atribuicao::cadastrar_atribuicao($usuario2->getId(), $tarefa2->getId(), "2024-09-25");
Atribuicao::remover_atribuicao($atribuicao1);
$atribuicao1->setDataAtribuicao("2024-09-09");
Atribuicao::atualizar_atribuicao_no_banco($atribuicao1);

//TESTES DE PRINTS
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

$resultados = Atribuicao::listar_atribuicoes_do_banco();
while ($atribuicoes_banco = pg_fetch_assoc($resultados)) {
    echo "<br>ID: {$atribuicoes_banco['id']}<br> Usuario ID: {$atribuicoes_banco['usuario_id']}<br>Tarefa ID: {$atribuicoes_banco['tarefa_id']}<br>Data Atribuição: {$atribuicoes_banco['data_atribuicao']}";
}

$conexao->DeletarTabelas();
$conexao->desconectar();