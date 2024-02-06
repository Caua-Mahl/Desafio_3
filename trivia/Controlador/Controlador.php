<?php
require_once "Classes/RequisitorCurl.php";
require_once "Classes/Pergunta.php";

class Controlador
{
    public static function get_perguntas()
    {

        $perguntas = RequisitorCurl::getApi();
        for ($i = 0; $i < 5; $i++) {
            $pergunta = $perguntas["results"][$i];
            echo "<pre>";
            var_dump($pergunta);
            $tipo = $pergunta["type"];
            $dificuldade = $pergunta["difficulty"];
            $categoria = $pergunta["category"];
            $questao = $pergunta["question"];
            $correta = $pergunta["correct_answer"];
            $erradas = implode(", ", $pergunta["incorrect_answers"]); //separa cada resposta errada por vírgula numa string
            Pergunta::cadastrar_pergunta($tipo, $dificuldade, $categoria, $questao, $correta, $erradas);
        }
    }
    public static function get_token()
    {
        $resultados = RequisitorCurl::get_token();
        return $resultados['token'];
    }
}