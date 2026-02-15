<?php

require_once 'config.php';
require_once 'utils.php';

validatePostRequest();

$inData = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    sendResponse(false, "Invalid JSON format");
}

$username= $inData['username'] ?? null;
$password  = $inData['password'] ?? null;

if (!$username || !$password) {
    sendResponse(false, "Missing username or password");
    return;
}

try {
    $conn = getDB();

    $checkStmt = $conn->prepare("SELECT ID FROM Users WHERE Username = ?");
    $checkStmt->execute([$username]);
    
    if ($checkStmt->rowCount() > 0) {
        sendResponse(false, "Username already exists");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertStmt = $conn->prepare("INSERT INTO Users (Username, Password) VALUES (?, ?)");
    $insertStmt->execute([$username, $hashedPassword]);

    $conn = null;
    sendResponse(true, "User registered successfully");

    } catch (PDOException $e) {
        error_log('Registration error: ' . $e->getMessage());
        sendResponse(false, "Registration failed. Please try again later");
}
?>