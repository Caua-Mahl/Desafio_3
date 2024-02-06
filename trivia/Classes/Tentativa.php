<?php 
    class Tentativa {
        private int $id;
        private int $usuario_id;
        private int $jogo_id;
        private string $resposta_1;
        private string $resposta_2;
        private string $resposta_3;
        private string $resposta_4;
        private string $resposta_5;
        private int $acertos;

        public function __construct(int $id, int $usuario_id, int $jogo_id, string $resposta_1, string $resposta_2, string $resposta_3, string $resposta_4, string $resposta_5, int $acertos) {
            $this->id = $id;
            $this->usuario_id = $usuario_id;
            $this->jogo_id = $jogo_id;
            $this->resposta_1 = $resposta_1;
            $this->resposta_2 = $resposta_2;
            $this->resposta_3 = $resposta_3;
            $this->resposta_4 = $resposta_4;
            $this->resposta_5 = $resposta_5;
            $this->acertos = $acertos;
        }

        public function getId() {
            return $this->id;
        }
        public function getUsuario_id() {
            return $this->usuario_id;
        }
        public function getJogo_id() {
            return $this->jogo_id;
        }
        public function getResposta_1() {
            return $this->resposta_1;
        }
        public function getResposta_2() {
            return $this->resposta_2;
        }
        public function getResposta_3() {
            return $this->resposta_3;
        }
        public function getResposta_4() {
            return $this->resposta_4;
        }
        public function getResposta_5() {
            return $this->resposta_5;
        }
        public function getAcertos() {
            return $this->acertos;
        }
        public function setId(int $id) {
            $this->id = $id;
        }
        public function setUsuario_id(int $usuario_id) {
            $this->usuario_id = $usuario_id;
        }
        public function setJogo_id(int $jogo_id) {
            $this->jogo_id = $jogo_id;
        }
        public function setResposta_1(string $resposta_1) {
            $this->resposta_1 = $resposta_1;
        }
        public function setResposta_2(string $resposta_2) {
            $this->resposta_2 = $resposta_2;
        }
        public function setResposta_3(string $resposta_3) {
            $this->resposta_3 = $resposta_3;
        }
        public function setResposta_4(string $resposta_4) {
            $this->resposta_4 = $resposta_4;
        }
        public function setResposta_5(string $resposta_5) {
            $this->resposta_5 = $resposta_5;
        }
        public function setAcertos(int $acertos) {
            $this->acertos = $acertos;
        }
    }
