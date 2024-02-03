<?php 
class Tarefa {
    private int    $id;
    private string $descricao;
    private int    $projeto_id;
    private string $data_inicio;
    private string $data_fim;

    public function __construct(string $descricao, string $data_inicio, string $data_fim){
        $this->descricao   = $descricao;
        $this->data_inicio = $data_inicio;
        $this->data_fim    = $data_fim;
    }

    public function getId(): int{
        return $this->id;
    }
    public function getDescricao(): string{
        return $this->descricao;
    }
    public function getProjetoId(): int{
        return $this->projeto_id;
    }
    public function getDataInicio(): string{
        return $this->data_inicio;
    }
    public function getDataFim(): string{
        return $this->data_fim;
    }
    public function setDescricao(string $descricao): void{
        $this->descricao = $descricao;
    }
    public function setDataInicio(string $data_inicio): void{
        $this->data_inicio = $data_inicio;
    }
    public function setDataFim(string $data_fim): void{
        $this->data_fim = $data_fim;
    }
}
