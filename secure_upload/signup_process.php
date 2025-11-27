<?php

require 'db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');
$password = trim($data['password'] ?? '');


if(empty($email) || empty($password)){
    echo json_encode(['success' => false, 'message' => 'Email and password required']);
    exit;
}



$check = $conn->prepare("SELECT id FROM user WHERE email = ?");
$check->bind_param("s",$email);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    echo json_encode(['success'=> false, 'message'=> 'email already exists']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $hashedPassword);

if($stmt-> execute()){
    echo json_encode(['success'=> true, 'message'=> 'signup successfull']);
} else {
    echo json_encode(['success'=>false, 'message'=>'Error:'.$stmt->error]);
}

$stmt->close();

$conn->close();

