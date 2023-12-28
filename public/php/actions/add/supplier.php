<?php
session_start();
include_once("../../functions.php");

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
    $conn = ConnectDB("root", "");
    // Check auth
    if (empty($_SESSION["login"])) {
        echo json_encode(["success" => false, "message" => "User is not authorized"]);
        exit();
    }

    // Check if supplier already exits
    $stmt = 'SELECT `companyName` FROM `supplier` WHERE `companyName` = :companyName';
    $data = [':companyName' => $input->companyName];

    if (CheckIfExists($stmt, $data, $conn)) {
        // Create error cookie
        echo json_encode(["success" => false, "message" => "Error: Company is already exist."]);
        exit();
    }

    $data = [
        ':supplierId' => GenerateUUID(),
        ':companyName' => $input->companyName,
        ':address' => $input->address,
        ':contactPerson' => $input->contactPerson,
        ':email' => $input->email,
        ':phone' => $input->phone
    ];

    $query = $conn->prepare("INSERT INTO supplier (supplierId, companyName, address, contactName, email, phone) 
    VALUES (:supplierId, :companyName, :address, :contactPerson, :email, :phone)");
    $query->execute($data);
    echo json_encode(["success" => true, "message" => "Supplier has been added successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit();
}
