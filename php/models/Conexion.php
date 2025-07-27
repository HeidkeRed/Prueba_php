<?php
require_once __DIR__ . '/../../install/config.php';

class Conexion {
    public static function conectar() {
        global $dsn, $user, $password;
        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
