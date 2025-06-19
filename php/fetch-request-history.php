<?php
include "../database/connect_db_reqwest.php";

$requestId = $_POST['request_id'] ?? '';
$documentType = $_POST['document_type'] ?? '';

if (!$requestId || !$documentType) {
    echo "Invalid request.";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM request_history WHERE request_id = ? AND document_type = ? ORDER BY id DESC");
$stmt->bind_param("is", $requestId, $documentType);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>No history found.</p>";
    exit;
}

echo "<ul class='history-list'>";
while ($row = $result->fetch_assoc()) {
    echo "<li class='history-item'>";

    foreach ($row as $column => $value) {
        echo "<strong>" . htmlspecialchars(ucwords(str_replace('_', ' ', $column))) . ":</strong> " . nl2br(htmlspecialchars($value)) . "<br>";
    }

    echo "</li><hr>";
}
echo "</ul>";


$stmt->close();
$conn->close();
?>
