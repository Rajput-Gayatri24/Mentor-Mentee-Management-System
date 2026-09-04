<?php
$host = 'localhost';
$db   = 'mentor_mentee_db';
$user = 'root';
$pass = 'Gayu@2405';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed: ' . $conn->connect_error]);
    exit;
}

$conn->set_charset('utf8mb4');
?>
