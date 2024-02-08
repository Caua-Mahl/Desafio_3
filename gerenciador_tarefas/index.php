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
$usuario2->set_nome('HSDAHSHDSGAF');
Usuario::atualizar_usuario_no_banco($usuario2);

//TESTES PROJETOS
$projeto1 = Projeto::cadastrar_projeto("teste 1", "testando projeto", "2023-02-10", "2024-03-11");
$projeto2 = Projeto::cadastrar_projeto("teste 2", "testando projeto", "2023-02-10", "2024-03-11");
//Projeto::remover_projeto($projeto1);
$projeto2->set_nome("Projeto verão");
Projeto::atualizar_projeto_no_banco($projeto2);

//TESTES TAREFAS
$tarefa1 = Tarefa::cadastrar_tarefa('tarefa teste', $projeto1->get_id(), "2023-02-10", "2024-03-11");
$tarefa2 = Tarefa::cadastrar_tarefa('teste tarefa', $projeto2->get_id(), "2023-08-11", "2024-12-19");
//Tarefa::remover_tarefa($tarefa1);
$tarefa2->set_descricao("Tarefa que sobrou");
Tarefa::atualizar_tarefa_no_banco($tarefa2);

//TESTES ATRIBUICOES
$atribuicao1 = Atribuicao::cadastrar_atribuicao($usuario1->get_id(), $tarefa1->get_id(), "2024-09-25");
$atribuicao2 = Atribuicao::cadastrar_atribuicao($usuario2->get_id(), $tarefa2->get_id(), "2024-09-25");
//Atribuicao::remover_atribuicao($atribuicao2);
$atribuicao1->set_data_atribuicao("2024-09-20");
Atribuicao::atualizar_atribuicao_no_banco($atribuicao1);

//$conexao->deletar_tabelas();
//FIM TESTES

// INTERATIVIDADE - SISTEMA DE GERENCIAMENTO DE TAREFAS
$sair=true;
do{
    echo "\n Usuarios: \n ";
    echo "1- criar usuario: \n ";
    echo "2- remover usuario: \n ";
    echo "3- atualizar usuario: \n ";
    echo "4- listar usuarios: \n ";

    echo "\n Projetos: \n ";
    echo "5- criar projeto: \n ";
    echo "6- remover projeto: \n ";
    echo "7- atualizar projeto: \n ";
    echo "8- listar projetos: \n ";

    echo "\n Tarefas: \n ";
    echo "9- criar tarefa: \n ";
    echo "10- remover tarefa: \n ";
    echo "11- atualizar tarefa: \n ";
    echo "12- listar tarefas: \n ";

    echo "\nAtribuições: \n ";
    echo "13- criar atribuição: \n ";
    echo "14- remover atribuição: \n ";
    echo "15- atualizar atribuição: \n ";
    echo "16- listar atribuições: \n ";

    echo "\n15- sair: \n ";
    $interatividade= intval(readline("Digite a opção desejada: "));
    switch($interatividade){
        case 1:
            $nome = readline("Digite o nome do usuario: ");
            $email = readline("Digite o email do usuario: ");
            $usuario = Usuario::cadastrar_usuario($nome, $email);
            break;
        case 2:
            $id = readline("Digite o id do usuario que deseja remover: ");
            $usuario = Usuario::remover_usuario($id);
            break;
        case 3:
            $id = readline("Digite o id do usuario que deseja atualizar: ");
            $nome = readline("Digite o novo nome do usuario: ");
            $email = readline("Digite o novo email do usuario: ");
            $usuario = Usuario::atualizar_usuario_no_banco(new Usuario($id, $nome, $email));
            break;
        case 4:
            $usuarios = Usuario::listar_usuarios_do_banco();
            foreach($usuarios as $usuario){
                echo "Nome: ".$usuario->get_nome()." Email: ".$usuario->get_email()."\n";
            }
            break;
        case 5:
            $nome = readline("Digite o nome do projeto: ");
            $descricao = readline("Digite a descrição do projeto: ");
            $data_inicio = readline("Digite a data de inicio do projeto: ");
            $data_fim = readline("Digite a data de fim do projeto: ");
            $projeto = Projeto::cadastrar_projeto($nome, $descricao, $data_inicio, $data_fim);
            break;
        case 6:
            $id = readline("Digite o id do projeto que deseja remover: ");
            // $projeto = Projeto::remover_projeto($id);
            break;
        case 7:
            $id = readline("Digite o id do projeto que deseja atualizar: ");
            $nome = readline("Digite o novo nome do projeto: ");
            $descricao = readline("Digite a nova descrição do projeto: ");
            $data_inicio = readline("Digite a nova data de inicio do projeto: ");
            $data_fim = readline("Digite a nova data de fim do projeto: ");
            //$projeto = Projeto::atualizar_projeto($id, $nome, $descricao, $data_inicio, $data_fim);
            break;
        case 8:
            $projetos = Projeto::listar_projetos_do_banco();
            foreach($projetos as $projeto){
                echo "Nome: ".$projeto->get_nome()." Descrição: ".$projeto->get_descricao()." Data de inicio: ".$projeto->get_data_inicio()." Data de fim: ".$projeto->get_data_fim()."\n";
            }
            break;
        case 9:
            $descricao = readline("Digite a descrição da tarefa: ");
            $id_projeto = readline("Digite o id do projeto da tarefa: ");
            $data_inicio = readline("Digite a data de inicio da tarefa: ");
            $data_fim = readline("Digite a data de fim da tarefa: ");
            $tarefa = Tarefa::cadastrar_tarefa($descricao, $id_projeto, $data_inicio, $data_fim);
            break;
        case 10:
            $tarefas = Tarefa::listar_tarefas_do_banco();
            foreach($tarefas as $tarefa){
                echo "Descrição: ".$tarefa->get_descricao()." Data de inicio: ".$tarefa->get_data_inicio()." Data de fim: ".$tarefa->get_data_fim()."\n";
            }
            break;
        case 11:
            $id_usuario = readline("Digite o id do usuario da atribuição: ");
            $id_tarefa = readline("Digite o id da tarefa da atribuição: ");
            $data_atribuicao = readline("Digite a data de atribuição da tarefa: ");
            $atribuicao = Atribuicao::cadastrar_atribuicao($id_usuario, $id_tarefa, $data_atribuicao);
            break;
        case 12:
            $id = readline("Digite o id da atribuição que deseja remover: ");
           // $atribuicao = Atribuicao::remover_atribuicao($id);
            break;
        case 13:
            $id = readline("Digite o id da atribuição que deseja atualizar: ");
            $id_usuario = readline("Digite o novo id do usuario da atribuição: ");
            $id_tarefa = readline("Digite o novo id da tarefa da atribuição: ");
            $data_atribuicao = readline("Digite a nova data de atribuição da tarefa: ");
            //$atribuicao = Atribuicao::atualizar_atribuicao($id, $id_usuario, $id_tarefa, $data_atribuicao);
            break;
        case 14:
            $atribuicoes = Atribuicao::listar_atribuicoes_do_banco();
            foreach($atribuicoes as $atribuicao){
                echo "Id do usuario: ".$atribuicao->get_id_usuario()." Id da tarefa: ".$atribuicao->get_id_tarefa()." Data de atribuição: ".$atribuicao->get_data_atribuicao()."\n";
            }
            break;
        case 15:
            $sair=false;
    }

}while($sair);

$conexao->desconectar();
//docker exec -it e8e5eb35ca7b /bin/bash