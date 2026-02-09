<?php

require_once 'config.php';
require_once 'utils.php';

$inData = json_decode(file_get_contents('php://input'), true);


$firstName = $inData['firstName'];
$lastName  = $inData['lastName'];
$login     = $inData['login'];
$password  = $inData['password'];

try {
    $conn = getDB();

    $checkStmt = $conn->prepare("SELECT ID FROM Users WHERE Login = ?");
    $checkStmt->execute([$login]);
    
    if ($checkStmt->rowCount() > 0) {
        sendResponse(false, "Username already exists");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertStmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES (?, ?, ?, ?)");
    $insertStmt->execute([$firstName, $lastName, $login, $hashedPassword]);

    sendResponse(true, "User registered successfully");

    } catch (PDOException $e) {
        sendResponse(false, "Registration error: " . $e->getMessage());
}
?>