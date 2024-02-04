<?php 
class Controlador{
    private static $conn;

    /*- Cadastro de Usuários:
        - Implemente a funcionalidade de cadastrar novos usuários no sistema.*/
    public static function cadastrarUsuario(string $nome, string $email){
        $usuario = new Usuario($nome, $email, self::$conn);
        $usuario->cadastrar();
        echo "<pre>";
        var_dump($usuario);
        echo "<br>";
    }

    /*- Criação de Tarefas:
        - Desenvolva a capacidade de criar novas tarefas, com descrição, data de início e data
        de término.*/
    public static function criarTarefa(string $descricao, string $data_inicio, string $data_fim){
        $tarefa = new Tarefa ($descricao, $data_inicio, $data_fim, self::$conn);
      //$tarefa->cadastrar();
    }
    
    /*- Visualização de Tarefas Atribuídas:
        - Crie uma funcionalidade que permite aos usuários visualizar as tarefas atribuídas a
        eles.*/
    public static function visualizarTarefasAtribuidas(int $id_usuario){
        //logica
    }

    //settar variavel estatica
    public static function setConn($conn){
        self::$conn = $conn;
    }
}