<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender = $_POST['sender'] ?? '';
    $message = $_POST['message'] ?? '';

    if ($sender === '' || $message === '') {
        echo json_encode(['error' => 'Missing sender or message']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO chat_messages (sender, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $sender, $message);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['error' => 'Insert failed: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    $sql = "SELECT * FROM chat_messages ORDER BY timestamp ASC LIMIT 50";
    $result = $conn->query($sql);
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    echo json_encode($messages);
}

$conn->close();
?>
