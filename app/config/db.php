<?php
class Database {
    public static function connect(): mysqli {
        $host = '127.0.0.1';
        $user = 'root';       // <--
        $pass = 'Ramchino8002';    // <--
        $db   = 'dejandohuelladb';
        $port = 3306;            // según tu Workbench

        $mysqli = new mysqli($host, $user, $pass, $db, $port);
        if ($mysqli->connect_errno) {
            die('Error de conexión: ' . $mysqli->connect_error);
        }
        $mysqli->set_charset('utf8mb4');
        return $mysqli;
    }
}
