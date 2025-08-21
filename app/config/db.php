<?php
class Database {
    public static function connect(): mysqli {
        $host = 'localhost';
        $user = 'root';       // <--
        $pass = '';    // <--

        $db   = 'dejandohuelladb';
        $port = 3306;            // según el Workbench

        $mysqli = new mysqli($host, $user, $pass, $db);
        if ($mysqli->connect_errno) {
            die('Error de conexión: ' . $mysqli->connect_error);
        }
        $mysqli->set_charset('utf8mb4');
        return $mysqli;
    }
}
