<?php
ob_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../db.php';

$id    = intval($_POST['id']          ?? 0);
$name  = trim($_POST['name']          ?? '');
$empId = trim($_POST['employee_id']   ?? '');
$dept  = trim($_POST['department']    ?? '');
$desig = trim($_POST['designation']   ?? '');
$maxM  = intval($_POST['max_mentees'] ?? 0);

if (!$id || !$name || !$empId || !$dept || !$desig || $maxM < 1) {
    ob_clean(); echo json_encode(['error' => 'All fields are required.']); exit;
}

$res = $conn->query("SELECT photo_path FROM mentors WHERE id = $id LIMIT 1");
if (!$res || $res->num_rows === 0) {
    ob_clean(); echo json_encode(['error' => 'Mentor not found.']); exit;
}
$photoPath = $res->fetch_assoc()['photo_path'];

if (!empty($_FILES['profile_photo']['name'])) {
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        ob_clean(); echo json_encode(['error' => 'Invalid file type.']); exit;
    }
    $uploadDir   = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $uniqueName  = 'mentor_' . uniqid('', true) . '.' . $ext;
    $destination = $uploadDir . $uniqueName;
    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $destination)) {
        if ($photoPath && file_exists(__DIR__ . '/../' . $photoPath)) unlink(__DIR__ . '/../' . $photoPath);
        $photoPath = 'uploads/' . $uniqueName;
    } else {
        ob_clean(); echo json_encode(['error' => 'Failed to save photo.']); exit;
    }
}

$stmt = $conn->prepare("UPDATE mentors SET name=?, employee_id=?, department=?, designation=?, max_mentees=?, photo_path=? WHERE id=?");
$stmt->bind_param('ssssisi', $name, $empId, $dept, $desig, $maxM, $photoPath, $id);

ob_clean();
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    $errMsg = ($conn->errno === 1062) ? "Employee ID \"$empId\" already exists for another mentor." : $conn->error;
    echo json_encode(['error' => $errMsg]);
}
$stmt->close(); $conn->close();