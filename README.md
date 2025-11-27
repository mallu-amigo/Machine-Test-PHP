# Secure File Upload System

This is a **PHP-based secure file upload system** that allows users to register, log in, and securely upload files. The system includes **file validation, size limits, file name sanitization, and logging** to ensure security.

---

## Features

- **User Authentication**
  - Sign up with email and password.
  - Login to access file upload functionality.
  - Only authenticated users can upload files.

- **Secure File Upload**
  - Accepts only `.jpg`, `.png`, `.pdf`, and `.docx` files.
  - Maximum file size: **5MB**.
  - Sanitizes file names to remove potentially harmful characters.
  - Generates unique file names to prevent overwriting.

- **Logging**
  - Tracks all upload attempts (success, rejected, suspicious).
  - Stores uploader's IP, file name, status, and timestamp in the `logs` table.

---

## Folder Structure

secure_upload/
│
├── css/ # Stylesheets
│ └── upload_form.css
├── js/ # JavaScript files
│ └── upload_form.js
├── uploads/ # Uploaded files (empty initially)
├── db.php # Database connection
├── signup_form.php # Signup page
├── signup_process.php # Signup processing
├── login_form.php # Login page
├── login_process.php # Login processing
├── upload_form.php # File upload page
├── upload_process.php # Upload processing
├── database.sql # Database creation SQL


---

## Database Setup

1. **Create the database**


CREATE DATABASE secure_upload;

You can use the provided database.sql file or run the following:

USE secure_upload;

-- User table
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Uploads table
CREATE TABLE uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

-- Logs table
CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    ip_address VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

Update database credentials in db.php

<?php
$host = 'localhost';
$user = 'root';        // Your MySQL username
$pass = '';            // Your MySQL password
$db   = 'secure_upload';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

How to Use

Open signup_form.php and register a new user.

Login via login_form.php.

Access upload_form.php to upload files.

Select a file (.jpg, .png, .pdf, .docx) and click Upload.

A success or failure alert will display the result.

Uploaded files are saved in the uploads/ folder.

Upload attempts are logged in the logs table.
