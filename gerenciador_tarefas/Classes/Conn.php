<?php
class Conn
{
    protected static $conn;

    public static function set_conn($conn)
    {
        self::$conn = $conn;
    }
    public static function get_conn()
    {
        return self::$conn;
    }
}