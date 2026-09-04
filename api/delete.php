<?php
ob_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../db.php';

$id = intval($_POST['id'] ?? 0);
if (!$id) { ob_clean(); echo json_encode(['error' => 'Invalid ID.']); exit; }

$res = $conn->query("SELECT photo_path FROM mentors WHERE id = $id LIMIT 1");
if (!$res || $res->num_rows === 0) { ob_clean(); echo json_encode(['error' => 'Mentor not found.']); exit; }
$photoPath = $res->fetch_assoc()['photo_path'];

$stmt = $conn->prepare("DELETE FROM mentors WHERE id = ?");
$stmt->bind_param('i', $id);

ob_clean();
if ($stmt->execute()) {
    if ($photoPath && file_exists(__DIR__ . '/../' . $photoPath)) unlink(__DIR__ . '/../' . $photoPath);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => $conn->error]);
}
$stmt->close(); $conn->close();