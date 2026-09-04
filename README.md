# Mentor-Mentee Management System

A full-stack web application to manage mentor records in an institutional setup — built with **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**.

## 🌐 Live Demo
**[http://mentoementeesys.xo.je](http://mentoementeesys.xo.je)**

---

## ✨ Features
- ➕ Add mentors with name, employee ID, department, designation, max mentees & profile photo
- 📋 View all mentors in a clean, responsive table
- ✏️ Edit mentor details via a modal popup
- 🗑️ Delete mentors with a confirmation dialog
- 📸 Profile photo upload & preview
- ✅ Real-time form validation
- 📥 Export mentor list as CSV
- 💾 Data persisted in MySQL database
- 📱 Fully responsive (mobile-friendly)

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML5, CSS3, Vanilla JavaScript |
| Backend | PHP 8 |
| Database | MySQL |
| Local Server | XAMPP (Apache + MySQL) |
| Hosting | InfinityFree |
| Version Control | Git + GitHub |

---

## 📁 Project Structure

```
mentor_mentee/
├── index.html          → Main UI (form + table + modals)
├── db.php              → MySQL database connection
├── setup.sql           → SQL to create database & table
├── api/
│   ├── add.php         → Add new mentor
│   ├── list.php        → Fetch all mentors (JSON)
│   ├── update.php      → Update mentor details
│   └── delete.php      → Delete mentor
└── uploads/            → Uploaded profile photos
```

---

## 🚀 Run Locally

1. Install [XAMPP](https://www.apachefriends.org/)
2. Clone this repo into your `htdocs` folder:
   ```bash
   git clone https://github.com/Rajput-Gayatri24/Mentor-Mentee-Management-System.git
   ```
3. Start Apache & MySQL from XAMPP Control Panel
4. Open **phpMyAdmin** and run `setup.sql` to create the database
5. Visit: `http://localhost/Mentor-Mentee-Management-System/`

---

## 🗄️ Database Setup

Run the following SQL in phpMyAdmin:

```sql
CREATE DATABASE IF NOT EXISTS mentor_mentee_db;
USE mentor_mentee_db;

CREATE TABLE IF NOT EXISTS mentors (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  name         VARCHAR(100) NOT NULL,
  employee_id  VARCHAR(50)  NOT NULL UNIQUE,
  department   VARCHAR(100) NOT NULL,
  designation  VARCHAR(100) NOT NULL,
  max_mentees  INT          NOT NULL DEFAULT 1,
  photo_path   VARCHAR(255) DEFAULT '',
  created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);
```

---

## 📸 Screenshots

> Add, edit, delete mentors with a clean professional UI

---

## 👩‍💻 Author

**Gayatri Rajput**
T.Y. B.Tech — Computer Science
WTL Mid-Term Lab Examination | 2026

---

## 📄 License
This project is for educational purposes.
