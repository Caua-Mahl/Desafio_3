<?php
class RequisitorCurl
{
    public static string $token = "https://opentdb.com/api_token.php?command=request";
    public static string $base = "https://opentdb.com/api.php?amount=5&token=";

    public static function internet(): bool
    {
        $conectado = @fsockopen(self::$base, 8102);
        if ($conectado) {
            fclose($conectado);
            return true;
        }
        return false;
    }

    public static function get_api(): array
    {
        $ch = curl_init(self::$base);

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