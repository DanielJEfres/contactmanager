<?php
require_once 'config.php';
require_once 'utils.php';

validatePostRequest();

$inData = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    sendResponse(false, "Invalid JSON format");
}

$userId = trim($inData['userId'] ?? '');
$firstName = trim($inData['firstName'] ?? '');
$lastName = trim($inData['lastName'] ?? '');
$phone = trim($inData['phone'] ?? '');
$email = trim($inData['email'] ?? '');

if (!$userId || !$firstName || !$lastName || !$phone || !$email) {
    sendResponse(false, "Missing one or more required fields");
    return;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendResponse(false, "Invalid email format");
    return;
}
if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
    sendResponse(false, "Invalid phone number format");
    return;
} 

try {
    $conn = getDB();

    $checkSql = "SELECT COUNT(*) FROM Contacts WHERE UserID = ? AND Email = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->execute([$userId, $email]);
    if ($stmt->fetchColumn() > 0) {
        sendResponse(false, "A contact with this email already exists for this user");
        return;
    }
    
    $sql = "INSERT INTO Contacts (UserID, FirstName, LastName, Phone, Email, DateCreated) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId, $firstName, $lastName, $phone, $email]);
    $conn = null; // forgot to close connection here
    
    sendResponse(true, "Contact added successfully");
    
} catch (PDOException $e) {
    error_log('Add Contact Error: ' . $e->getMessage());
    sendResponse(false, "Failed to add contact. Please try again later");
}
?>