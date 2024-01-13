<?php
session_start();
include("../functions.php");

// Connect to DB
$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    // Since we still need to create a user, this'll be commented out

    // Check for admin status
    if (!CheckAuth(3, $conn)) {
        // Create error cookie

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check for email and phone
    $stmt = 'SELECT `email`, `phone` FROM `user` WHERE `email` = :email OR `phone` = :phone';
    $data = [
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone']
    ];
    if (CheckIfExists($stmt, $data, $conn)) {
        // Create error cookie

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Insert new user into db
    // Get data
    $data = [
        ':id' => GenerateUUID(),
        ':firstName' => $_POST['firstName'],
        ':middleName' => $_POST['middleName'],
        ':lastName' => $_POST['lastName'],
        ':password' => password_hash('12345678', PASSWORD_BCRYPT),
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone'],
        ':address' => $_POST['address'],
        ':auth' => $_POST['auth']
    ];

    // Query DB
    $query = $conn->prepare('INSERT INTO `user`
        (`userId`, `firstName`, `middleName`, `lastName`, `password`, `email`, `phone`, `address`, `auth`)
        VALUES (:id, :name, :middleName, :lastName, :password, :email, :phone, :address, :auth)
        ');
    $query->execute($data);

    $query->closeCursor();
    echo json_encode(["success" => true, "message" => "User has been added successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);

    exit();
}
