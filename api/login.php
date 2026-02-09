<?php

require_once 'config.php';
require_once 'utils.php';

$inData = json_decode(file_get_contents('php://input'), true);

$username= $inData['username'] ?? null;
$password = $inData['password'] ?? null;

if (!$username || !$password) {
    sendResponse(false, "Missing username or password");
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
            "username" => $username
        ];

        sendResponse(true, "Login successful", $responseData);

    } else {
        sendResponse(false, "Login/Password incorrect");
    }

} catch (PDOException $e) {
    sendResponse(false, "Login error: " . $e->getMessage()); // reminder: remove db error details in final release
}
?>