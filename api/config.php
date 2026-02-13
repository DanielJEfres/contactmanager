<?php

function getDB() {
    // need filling in via details on digital ocean
    $host = "fill ip";
    $db   = "fill db name";
    $user = "fill username";
    $pass = "fill passwrd";
    $charset = 'utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARE => false,
    ];
    

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";


    return new PDO($dsn, $user, $pass, $options);
    
}
?>