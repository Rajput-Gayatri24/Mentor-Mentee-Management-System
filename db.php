<?php
$host = 'sql300.infinityfree.com';
$db   = 'if0_42833754_mentordb';
$user = 'if0_42833754';
$pass = 'dlmTq9fJiNQHiqC';
$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed: ' . $conn->connect_error]);
    exit;
}

$conn->set_charset('utf8mb4');

// Auto-create table if it does not exist
$conn->query("CREATE TABLE IF NOT EXISTS mentors (
  id           INT          NOT NULL AUTO_INCREMENT,
  name         VARCHAR(100) NOT NULL,
  employee_id  VARCHAR(50)  NOT NULL,
  department   VARCHAR(100) NOT NULL,
  designation  VARCHAR(100) NOT NULL,
  max_mentees  INT          NOT NULL DEFAULT 1,
  photo_path   VARCHAR(255) NOT NULL DEFAULT '',
  created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_employee_id (employee_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
?>
