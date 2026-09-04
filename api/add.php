<?php
ob_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../db.php';

$name  = trim($_POST['name']          ?? '');
$empId = trim($_POST['employee_id']   ?? '');
$dept  = trim($_POST['department']    ?? '');
$desig = trim($_POST['designation']   ?? '');
$maxM  = intval($_POST['max_mentees'] ?? 0);

if (!$name || !$empId || !$dept || !$desig || $maxM < 1) {
    ob_clean(); echo json_encode(['error' => 'All fields are required.']); exit;
}

$photoPath = '';
if (!empty($_FILES['profile_photo']['name'])) {
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        ob_clean(); echo json_encode(['error' => 'Invalid file type. Allowed: jpg, jpeg, png, gif, webp.']); exit;
    }
    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $uniqueName  = 'mentor_' . uniqid('', true) . '.' . $ext;
    $destination = $uploadDir . $uniqueName;
    if (!move_uploaded_file($_FILES['profile_photo']['tmp_name'], $destination)) {
        ob_clean(); echo json_encode(['error' => 'Failed to save photo.']); exit;
    }
    $photoPath = 'uploads/' . $uniqueName;
}

$stmt = $conn->prepare("INSERT INTO mentors (name, employee_id, department, designation, max_mentees, photo_path) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssssis', $name, $empId, $dept, $desig, $maxM, $photoPath);

ob_clean();
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $conn->insert_id]);
} else {
    $errMsg = ($conn->errno === 1062) ? "Employee ID \"$empId\" already exists." : $conn->error;
    echo json_encode(['error' => $errMsg]);
}
$stmt->close(); $conn->close();