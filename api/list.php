<?php
ob_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../db.php';

$result = $conn->query("SELECT id, name, employee_id, department, designation, max_mentees, photo_path FROM mentors ORDER BY id DESC");
if (!$result) { ob_clean(); echo json_encode(['error' => $conn->error]); exit; }

$rows = [];
while ($row = $result->fetch_assoc()) $rows[] = $row;
$conn->close();

ob_clean();
echo json_encode($rows);