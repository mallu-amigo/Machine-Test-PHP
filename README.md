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
├── css/
│   └── upload_form.css
├── js/
│   └── upload_form.js
├── uploads/              # Uploaded files stored here
├── db.php                # Database connection
├── signup_form.php
├── signup_process.php
├── login_form.php
├── login_process.php
├── upload_form.php
├── upload_process.php
├── database.sql          # SQL file for creating tables



## Database Setup

1. **Create the database**


CREATE DATABASE secure_upload;

You can use the provided database.sql file 
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
