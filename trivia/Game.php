<?php

require_once "init.php";
class Game {

    public static function jogo($perguntas){
        if (!isset($_SESSION['indice_pergunta'])) {
            $_SESSION['indice_pergunta'] = 0;
        } // pra começar da pergunta 1 se não tiver nada definido


        // Verificam  se o botão "Avançar" ou "Voltar" foi pressionado
        if (isset($_POST['avançar']) && $_SESSION['indice_pergunta'] < 4) { 
            $_SESSION['indice_pergunta']++;
        }
        if (isset($_POST['voltar']) && $_SESSION['indice_pergunta'] > 0) {
            $_SESSION['indice_pergunta']--;
        }

        var_dump($_SESSION['indice_pergunta']);
        

        $pergunta = $perguntas[$_SESSION['indice_pergunta']]; // pega a pergunta de acordo com o indice, o $perguntas é uma array de objetos Pergunta

        echo "<h2>" . $pergunta->getQuestao() . "</h2>";
        echo "<form action=\"\" method=\"post\">";
        echo "<input type=\"radio\" name=\"resposta\" value=\"" . $pergunta->getCorreta() . "\">" . $pergunta->getCorreta() . "<br>";
        if ($pergunta->getTipo() == "multiple") {
            $erradas = explode(", ", $pergunta->getErradas());
            for($j = 0; $j < 3; $j++){
                echo "<input type=\"radio\" name=\"resposta\" value=\"" . $erradas[$j] . "\">" . $erradas[$j] . "<br>";
            }
        } else {
            echo "<input type=\"radio\" name=\"resposta\" value=\"" . $pergunta->getErradas() . "\">" . $pergunta->getErradas() . "<br>";
        }


        
        if ($_SESSION['indice_pergunta'] > 0) { // se nao tiver na primeira pergunta aparece o botão de voltar
            echo "<input type=\"submit\" name=\"voltar\" value=\"Voltar\">";
        }
        if ($_SESSION['indice_pergunta'] == 4) { // se nao tiver na ultima pergunta aparece o botão de avançar se tiver aparece o botão de enviar
            echo "<input type=\"submit\" name=\"enviar\" value=\"Enviar\">";
        } else {
            echo "<input type=\"submit\" name=\"avançar\" value=\"Avançar\">";
        }   
        echo "</form>";
    }
}