<?php
require_once 'config.php';
require_once 'utils.php';

$inData = json_decode(file_get_contents('php://input'), true);

$userId = trim($inData['userId'] ?? '');
$search = trim($inData['search'] ?? '');

if (!$userId) {
    sendResponse(false, "Missing userId");
    return;
}

try {
    $conn = getDB();

    if ($search === '') { // if search is empty return ALL contacts for the user
        $sql = "SELECT ID, FirstName, LastName, Phone, Email
                FROM Contacts
                WHERE UserID = ?
                ORDER BY LastName ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId]);
    } 

    else { // otherwise do a search based on the input from the user
        $term = "%" . $search . "%";
        $sql = "SELECT ID, FirstName, LastName, Phone, Email
                FROM Contacts
                WHERE UserID = ?
                AND (
                    FirstName LIKE ?
                    OR LastName LIKE ?
                    OR Email LIKE ?
                    OR Phone LIKE ?
                )
                ORDER BY LastName ASC"; // search by first name, last name, email, or phone and then order response by last name ascending
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId, $term, $term, $term, $term]);
    }

    $results = $stmt->fetchAll();
    $conn = null;

    sendResponse(true, "Search completed", $results);

} catch (PDOException $e) {
    sendResponse(false, "Search Contacts Error: " . $e->getMessage()); // remove details in final
}
?>
