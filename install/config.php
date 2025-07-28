<?php

// Evitar múltiples inclusiones
if (!defined('CONFIG_LOADED')) {
    define('CONFIG_LOADED', true);

    // Datos de conexión
    $host = 'localhost:3307';
    $dbname = 'tienda3';
    $user = 'root';
    $password = '';

    // DSN para PDO
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    // Ruta del archivo de log
    $log_file = __DIR__ . '/init_db_log.txt';

    // Directorio base del proyecto
    $base_dir = dirname(__DIR__);
}
?>
