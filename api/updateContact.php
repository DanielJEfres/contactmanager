<?php
require_once 'config.php';
require_once 'utils.php';

validatePostRequest();

$inData = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    sendResponse(false, "Invalid JSON format");
}

$contactId = trim($inData['contactId'] ?? '');
$userId = trim($inData['userId'] ?? '');
$firstName = trim($inData['firstName'] ?? '');
$lastName = trim($inData['lastName'] ?? '');
$phone = trim($inData['phone'] ?? '');
$email = trim($inData['email'] ?? '');

if (!$contactId || !$userId || !$firstName || !$lastName || !$phone || !$email) {
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

    $checkSql = "SELECT COUNT(*) FROM Contacts WHERE UserID = ? AND Email = ? AND ID != ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->execute([$userId, $email, $contactId]);
    if ($stmt->fetchColumn() > 0) {
        sendResponse(false, "A contact with this email already exists for this user");
        return;
    }
    
    $sql = "UPDATE Contacts SET FirstName = ?, LastName = ?, Phone = ?, Email = ? WHERE ID = ? AND UserID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$firstName, $lastName, $phone, $email, $contactId, $userId]);
    
    if ($stmt->rowCount() > 0) {
        $conn = null;
        sendResponse(true, "Contact updated");
    } else {
        $conn = null;
        sendResponse(false, "Contact not found");
    }
    
} catch (PDOException $e) {
    error_log('Update Contact Error: ' . $e->getMessage());
    sendResponse(false, "Failed to update contact. Please try again later");
}
?>
