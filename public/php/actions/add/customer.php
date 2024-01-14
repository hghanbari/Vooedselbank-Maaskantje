<?php
session_start();
include_once("../../functions.php");

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
    // Check auth
    if (empty($_SESSION["login"])) {
        echo json_encode(["success" => false, "message" => "User is not authorized"]);
        exit();
    }

    // Check for same email / phone
    $stmt = 'SELECT `email`, `phone` FROM `customer` WHERE `email` = :email';
    $data = [
        ':email' => $input->email,
    ];
    if (CheckIfExists($stmt, $data, $conn)) {
        echo json_encode(["success" => false, "message" => "This email or phone already exists"]);
        exit();
    }
    unset($data);

    // Insert into DB
    $id = GenerateUUID();
    $data = [
        ':id' => $id,
        ':firstName' =>  $input->firstName,
        ':middleName' => $input->middleName,
        ':lastName' => $input->lastName,
        ':email' => $input->email,
        ':phone' => $input->phone,
        ':address' => $input->address,
        ':amount' => $input->amount,
        ':age' => $input->age
    ];

    $query = $conn->prepare(
        'INSERT INTO `customer`
        (`customerId`, `firstName`, `middleName` , `lastName`, `email`, `phone`,`address`, `familyMemberAmount`, `youngestPerson`)
        VALUES (:id, :firstName,:middleName, :lastName, :email, :phone, :address,:amount, :age)'
    );
    $query->execute($data);

    echo json_encode(["success" => true, "message" => "Customer has been added successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit();
}
