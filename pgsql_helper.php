<?php
// PostgreSQL helper for PHP using PDO
function pgsql_connect($config) {
    $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
    try {
        $pdo = new PDO($dsn, $config['username'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
}
