-- ============================================================
-- Mentor-Mentee Management System - Database Setup
-- Run this once in phpMyAdmin (Import tab) or MySQL console
-- ============================================================

CREATE DATABASE IF NOT EXISTS mentor_mentee_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE mentor_mentee_db;

CREATE TABLE IF NOT EXISTS mentors (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
