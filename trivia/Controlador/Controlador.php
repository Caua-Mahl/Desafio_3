<?php

require_once "Classes/RequisitorCurl.php";

class Controlador
{
    public static function jogar()
    {
        $jogo = [];
        if (RequisitorCurl::internet()) {
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
                if ($tipo && $dificuldade && $categoria && $questao && $correta && $erradas) {
                    $jogo[$i] = Pergunta::cadastrar_pergunta($tipo, $dificuldade, $categoria, $questao, $correta, $erradas);
                } else {
                    throw new Exception("Não foi possível cadastrar uma pergunta");
                }
            }
        }
        $conn = Conn::get_conn();
        $sql = 'SELECT id FROM perguntas ORDER BY RANDOM() LIMIT $1';
        $resultado = pg_query_params($conn, $sql, array(5));

        if ($resultado === false) {
            throw new Exception("Erro ao buscar perguntas: " . pg_last_error($conn));
        }

        $IDs = [];
        while ($linha = pg_fetch_assoc($resultado)) {
            $IDs[] = $linha['id'];
        }

        return $jogo = Jogo::cadastrar_jogo($IDs[0], $IDs[1], $IDs[2], $IDs[3], $IDs[4]);

    }
    public static function get_token()
    {
        if (RequisitorCurl::internet()) {
            $resultados = RequisitorCurl::get_token();
            return $resultados['token'];
        }
        echo "Sem net, puxando do DB";
        return bin2hex(openssl_random_pseudo_bytes(32)); //gera um token aleatorio de 64 caracteres igual o numero de caracteres q o token gera, porem pode repetir, e se repetir da pau
    }

}