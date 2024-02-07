<?php

require_once "Classes/RequisitorCurl.php";

class Controlador
{
    public static function jogar()
    {
        $perguntas = RequisitorCurl::get_api();
        $jogo = [];
        for ($i = 0; $i < 5; $i++) {
            $pergunta = $perguntas["results"][$i];
            $tipo = $pergunta["type"];
            $dificuldade = $pergunta["difficulty"];
            $categoria = $pergunta["category"];
            $questao = $pergunta["question"];
            $correta = $pergunta["correct_answer"];
            if ($tipo == "multiple") {
                $erradas = implode(", ", $pergunta["incorrect_answers"]);
            } else {
                $erradas = $pergunta["incorrect_answers"][0];
            }
            $jogo[$i] = Pergunta::cadastrar_pergunta($tipo, $dificuldade, $categoria, $questao, $correta, $erradas);
        }
        return $jogo = Jogo::cadastrar_jogo($jogo[0]->getId(), $jogo[1]->getId(), $jogo[2]->getId(), $jogo[3]->getId(), $jogo[4]->getId());
    }

    public static function get_token()
    {
        $resultados = RequisitorCurl::get_token();
        return $resultados['token'];
    }
}