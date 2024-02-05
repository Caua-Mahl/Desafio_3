<?php
class Projeto
{
    private int $id;
    private string $nome;
    private string $descricao;
    private string $data_inicio;
    private string $data_fim;

    public function __construct(string $nome, string $descricao, string $data_inicio, string $data_fim)
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->data_inicio = $data_inicio;
        $this->data_fim = $data_fim;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }
    public function getDescricao(): string
    {
        return $this->descricao;
    }
    public function getDataInicio(): string
    {
        return $this->data_inicio;
    }
    public function getDataFim(): string
    {
        return $this->data_fim;
    }
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }
    public function setDataInicio(string $data_inicio): void
    {
        $this->data_inicio = $data_inicio;
    }
    public function setDataFim(string $data_fim): void
    {
        $this->data_fim = $data_fim;
    }


}