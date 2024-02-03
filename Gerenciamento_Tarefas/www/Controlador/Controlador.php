<?php 
class Controlador{

    /*- Cadastro de Usuários:
        - Implemente a funcionalidade de cadastrar novos
        usuários no sistema.*/
    public static function cadastrarUsuario(string $nome, string $email, string $senha, string $tipo){
        $usuario = new Usuario($nome, $email, $senha, $tipo);
        //$usuario->cadastrar();
    }

    /*- Criação de Tarefas:
        - Desenvolva a capacidade de criar novas tarefas, com descrição, data de início e data
        de término.*/
    public static function criarTarefa(string $descricao, string $data_inicio, string $data_fim){
        $tarefa = new Tarefa ($descricao, $data_inicio, $data_fim);
      //$tarefa->cadastrar();
    }
    
    /*- Visualização de Tarefas Atribuídas:
        - Crie uma funcionalidade que permite aos usuários visualizar as tarefas atribuídas a
        eles.*/
    public static function visualizarTarefasAtribuidas(int $id_usuario){
        //logica
    }
}