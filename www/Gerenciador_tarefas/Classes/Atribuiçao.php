<?php 
class Atribuiçao {
    private int    $id;
    private int    $tarefa_id;
    private int    $usuario_id;
    private string $data_atribuicao;

    public function __construct(int $id, int $tarefa_id, int $usuario_id, string $data_atribuicao){
        $this->id              = $id;
        $this->tarefa_id       = $tarefa_id;
        $this->usuario_id      = $usuario_id;
        $this->data_atribuicao = $data_atribuicao;
    }

    public function getId(): int{
        return $this->id;
    }
    public function getTarefaId(): int{
        return $this->tarefa_id;
    }
    public function getUsuarioId(): int{
        return $this->usuario_id;
    }
    public function getDataAtribuicao(): string{
        return $this->data_atribuicao;
    }
    public function setId(int $id): void{
        $this->id = $id;
    }
    public function setTarefaId(int $tarefa_id): void{
        $this->tarefa_id = $tarefa_id;
    }
    public function setUsuarioId(int $usuario_id): void{
        $this->usuario_id = $usuario_id;
    }
    public function setDataAtribuicao(string $data_atribuicao): void{
        $this->data_atribuicao = $data_atribuicao;
    }
}