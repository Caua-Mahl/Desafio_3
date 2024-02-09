<?php
class RequisitorCurl
{
    public static string $token = "https://opentdb.com/api_token.php?command=request";
    public static string $base = "https://opentdb.com/api.php?amount=5&token=";

    public static function internet(): bool
    {
        $ch = curl_init('https://www.google.com'); // se usasse o $base, iria cair naquele problema da api de bugar de chamada duas vezes, pq depois chamo dnv o mesmo url
        curl_setopt($ch, CURLOPT_NOBODY, true); // ta excluindo corpo pra n dar pau
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $executar = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return !($status >= 200 && $status < 300); // se o status tiver entre 200 e 300, Tem
    }

    public static function get_api(string $token): array
    {

        $base = self::$base . $token;
        $ch = curl_init($base);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            http_response_code(400);
            echo json_encode(['message' => 'Curl error: ' . curl_error($ch)]);
            exit;
        }

        curl_close($ch);
        $decoded = json_decode($response, true);

        if (!$decoded) {
            http_response_code(404);
            echo json_encode(['message' => 'Data not found']);
            exit;
        }

        return $decoded;
    }
    public static function get_token(): array
    {

        $ch = curl_init(static::$token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            http_response_code(400);
            echo json_encode(['message' => 'Curl error: ' . curl_error($ch)]);
            exit;
        }

        curl_close($ch);
        $decoded = json_decode($response, true);

        if (!$decoded) {
            http_response_code(404);
            echo json_encode(['message' => 'Data not found']);
            exit;
        }
        return $decoded;
    }
}
