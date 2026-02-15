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

if (!$contactId || !$userId) {
    sendResponse(false, "Missing one or more required fields");
    return;
}

try {
    $conn = getDB();
    
    $sql = "DELETE FROM Contacts 
            WHERE ID = ? AND UserID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$contactId, $userId]);
    
    if ($stmt->rowCount() > 0) {
        $conn = null;
        sendResponse(true, "Contact deleted");
    } else {
        $conn = null;
        sendResponse(false, "Contact not found or can't delete");
    }
    
} catch (PDOException $e) {
    error_log('Delete Contact Error: ' . $e->getMessage());
    sendResponse(false, "Failed to delete contact. Please try again later");
}
?>
