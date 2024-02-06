<?php

require_once "Classes/RequisitorCurl.php";

class Controlador
{
    public static function get_perguntas()
    {

        $perguntas = RequisitorCurl::getApi();
        for ($i = 0; $i < 5; $i++) {
            $pergunta = $perguntas["results"][$i];
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

