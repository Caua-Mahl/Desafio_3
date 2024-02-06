<?php

class Controlador
{

    public static function perguntas()
    {

        $perguntas = RequisitorCurl::get_api("https://opentdb.com/api.php?amount=5");
        for ($i = 0; $i < 5; $i++) {
            $pergunta = $perguntas["results"][$i];
            $tipo = $pergunta["type"];
            $dificuldade = $pergunta["difficulty"];
            $categoria = $pergunta["category"];
            $questao = $pergunta["question"];
            $correta = $pergunta["correct_answer"];
            if ($tipo == "multiple") {
                $erradas = implode(", ", $pergunta["incorrect_answers"]); //separa cada resposta errada por vírgula numa string
            } else {
                $erradas = $pergunta["incorrect_answers"][0];
            }
            Pergunta::cadastrar_pregunta($tipo, $dificuldade, $categoria, $questao, $correta, $erradas);
        }
    }

    public static function usuario()
    {
        $token= RequisitorCurl::get_api("https://opentdb.com/api_token.php?command=request");
        var_dump($token);

    }
}
