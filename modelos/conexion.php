<?php

class Conexion {

    static public function conectar() {

        $host = "localhost";
        $port = "3307"; // <-- PUERTO CORRECTO
        $db   = "precal2025";
        $user = "root";
        $pass = "";

        try {
            $link = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $link;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}