<?php
// Supports both Railway (env vars) and XAMPP (local fallback)
$host = getenv('MYSQLHOST')     ?: getenv('DB_HOST')     ?: 'localhost';
$db   = getenv('MYSQLDATABASE') ?: getenv('DB_NAME')     ?: 'mentor_mentee_db';
$user = getenv('MYSQLUSER')     ?: getenv('DB_USER')     ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: getenv('DB_PASSWORD') ?: 'Gayu@2405';
$port = getenv('MYSQLPORT')     ?: getenv('DB_PORT')     ?: '3306';

$conn = new mysqli($host, $user, $pass, $db, (int)$port);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed: ' . $conn->connect_error]);
    exit;
}

$conn->set_charset('utf8mb4');

// Auto-create table if it does not exist (needed on fresh Railway deploy)
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