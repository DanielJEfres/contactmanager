<?php

require_once 'config.php';
require_once 'utils.php';

validatePostRequest();

$inData = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    sendResponse(false, "Invalid JSON format");
}

$username= $inData['username'] ?? null;
$password = $inData['password'] ?? null;

if (!$username || !$password) {
    sendResponse(false, "Missing username or password");
    return;
}

try {
    $conn = getDB();

    $stmt = $conn->prepare("SELECT ID, Password FROM Users WHERE Username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() == 0) {
        sendResponse(false, "Login/Password incorrect");
        exit();
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $row['Password'])) {
        
        $responseData = [
        $conn = null;
        sendResponse(true, "Login successful", $responseData);

    } else {
        $conn = null;

        sendResponse(true, "Login successful", $responseData);

    } else {
        sendResponse(false, "Login/Password incorrect");
    }

} catch (PDOException $e) {
    error_log('Login error: ' . $e->getMessage());
    sendResponse(false, "Login failed. Please try again later");
}
?>