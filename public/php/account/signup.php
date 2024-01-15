<?php
session_start();
include_once("../functions.php");

// Connect to DB
$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}

$json = file_get_contents('php://input');

// Converts it into a PHP object
$input = json_decode($json);

try {
    // Check for admin status
    //if (!CheckAuth(3, $conn)) {
    //    // Create error cookie
    //
    //    header('Location: ' . $_SERVER['HTTP_REFERER']);
    //    exit();
    //}

    // Check for email and phone
    $stmt = 'SELECT `email`, `phone` FROM `user` WHERE `email` = :email OR `phone` = :phone';
    $data = [
        ':email' => $input->email,
        ':phone' => $input->phone
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
        ':firstName' => $input->firstName,
        ':middleName' => $input->middleName,
        ':lastName' => $input->lastName,
        ':password' => password_hash($input->password, PASSWORD_BCRYPT),
        ':email' => $input->email,
        ':phone' => $input->phone,
        ':address' => $input->address,
        ':auth' => intval($input->auth)
    ];

    // Query DB
    $query = $conn->prepare('INSERT INTO `user`
        (`userId`, `firstName`, `middleName`, `lastName`, `password`, `email`, `phone`, `address`, `auth`)
        VALUES (:id, :firstName, :middleName, :lastName, :password, :email, :phone, :address, :auth)
        ');
    $query->execute($data);

    $query->closeCursor();
    echo json_encode(["success" => true, "message" => "User has been added successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);

    exit();
}
