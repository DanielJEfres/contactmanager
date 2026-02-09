<?php

require_once 'config.php';
require_once 'utils.php';

$inData = json_decode(file_get_contents('php://input'), true);

$login = $inData['login'];
$password = $inData['password'];

try {
    $conn = getDB();

    $stmt = $conn->prepare("SELECT ID, FirstName, LastName, Password FROM Users WHERE Login = ?");
    $stmt->execute([$login]);
    
    if ($stmt->rowCount() == 0) {
        sendResponse(false, "Login/Password incorrect");
        exit();
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $row['Password'])) {
        
        $responseData = [
            "id" => $row['ID'],
            "firstName" => $row['FirstName'],
            "lastName" => $row['LastName']
        ];

        sendResponse(true, "Login successful", $responseData);

    } else {
        sendResponse(false, "Login/Password incorrect");
    }

} catch (PDOException $e) {
    sendResponse(false, "Login error: " . $e->getMessage());
}
?>