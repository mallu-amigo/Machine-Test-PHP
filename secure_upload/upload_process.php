<?php
session_start();
require 'db.php';

// Show all errors for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Always return JSON
header('Content-Type: application/json');

// Check login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$ip = $_SERVER['REMOTE_ADDR'];

// Helper function to log uploads
function logUpload($conn, $user_id, $fileName, $ip, $status) {
    $stmt = $conn->prepare("INSERT INTO logs (user_id, file_name, ip_address, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $fileName, $ip, $status);
    if (!$stmt->execute()) {
        error_log("Log insert failed: " . $stmt->error);
    }
}

// Check file upload
if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
    $fileName = $_FILES['file']['name'] ?? 'No file';
    logUpload($conn, $user_id, $fileName, $ip, 'rejected');
    echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
    exit;
}

$file = $_FILES['file'];
$fileName = $file['name'];

// File type validation (you already limit selection in HTML, but extra safety)
$allowedExtensions = ['jpg', 'png', 'pdf', 'docx'];
$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
if (!in_array($ext, $allowedExtensions)) {
    logUpload($conn, $user_id, $fileName, $ip, 'rejected');
    echo json_encode(['success' => false, 'message' => 'File type not allowed']);
    exit;
}

// File size validation (5MB)
$maxSize = 5 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    logUpload($conn, $user_id, $fileName, $ip, 'rejected');
    echo json_encode(['success' => false, 'message' => 'File exceeds 5MB']);
    exit;
}

// Sanitize filename & generate unique name
$sanitized = preg_replace("/[^a-zA-Z0-9-_\.]/", "_", $fileName);
$uniqueName = uniqid() . '_' . $sanitized;
$uploadDir = "uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Move file
if (move_uploaded_file($file['tmp_name'], $uploadDir . $uniqueName)) {
    // Insert into uploads table
    $stmtUp = $conn->prepare("INSERT INTO uploads (user_id, original_name) VALUES (?, ?)");
    $stmtUp->bind_param("is", $user_id, $fileName);
    if (!$stmtUp->execute()) {
        logUpload($conn, $user_id, $fileName, $ip, 'rejected');
        echo json_encode(['success' => false, 'message' => 'Failed to save file record']);
        exit;
    }

    // Insert success log
    logUpload($conn, $user_id, $uniqueName, $ip, 'success');

    echo json_encode(['success'=> true, 'message'=> 'File uploaded successfully']);
    exit;
} else {
    logUpload($conn, $user_id, $fileName, $ip, 'rejected');
    echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
    exit;
}
