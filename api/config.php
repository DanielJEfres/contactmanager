<?php

function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception('.env file not found');
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0 || trim($line) === '') {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
        }
    }
}

loadEnv(__DIR__ . '/../.env');

function getDB() {
    $host = $_ENV['DB_HOST'] ?? null;
    $db = $_ENV['DB_NAME'] ?? null;
    $user = $_ENV['DB_USER'] ?? null;
    $pass = $_ENV['DB_PASS'] ?? null;
    $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

    if (!$host || !$db || !$user || !$pass) {
        throw new Exception('Database configuration is incomplete. Check .env file.');
    }

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARE => false,
    ];

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        error_log('Database connection failed: ' . $e->getMessage());
        throw new Exception('Database connection failed');
    }
}
?>