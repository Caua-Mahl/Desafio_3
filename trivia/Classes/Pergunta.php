<?php 
    class Pergunta {
        private int $id;
        private string $dificuldade;
        private string $categoria;
        private string $questao;
        private string $correta;
        private string $errada;

        public function __construct(int $id, string $dificuldade, string $categoria, string $questao, string $correta, string $errada) {
            $this->id = $id;
            $this->dificuldade = $dificuldade;
            $this->categoria = $categoria;
            $this->questao = $questao;
            $this->correta = $correta;
            $this->errada = $errada;
        }

        public function getId() {
            return $this->id;
        }
        public function getDificuldade() {
            return $this->dificuldade;
        }
        public function getCategoria() {
            return $this->categoria;
        }
        public function getQuestao() {
            return $this->questao;
        }
        public function getCorreta() {
            return $this->correta;
        }
        public function getErrada() {
            return $this->errada;
        }
        public function setId(int $id) {
            $this->id = $id;
        }   
        public function setDificuldade(string $dificuldade) {
            $this->dificuldade = $dificuldade;
        }
        public function setCategoria(string $categoria) {
            $this->categoria = $categoria;
        }
        public function setQuestao(string $questao) {
            $this->questao = $questao;
        }
        public function setCorreta(string $correta) {
            $this->correta = $correta;
        }
        public function setErrada(string $errada) {
            $this->errada = $errada;
        }
    }
