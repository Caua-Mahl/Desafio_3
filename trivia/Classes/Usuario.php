<?php 

require_once "Conn.php";
    class Usuario extends Conn{
        private int $id;
        private string $token;

        public function __construct(int $id, string $token) {
            $this->id = $id;
            $this->token = $token;
        }

        public function getId() {
            return $this->id;
        }
        public function getToken() {
            return $this->token;
        }
        public function setId(int $id) {
            $this->id = $id;
        }
        public function setToken(string $token) {
            $this->token = $token;
        }
    }