<?php
session_start();
include_once('../../functions.php');

$conn = ConnectDB('root', '');

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}

try {
    $json = file_get_contents('php://input');

    // Converts it into a PHP object
    $input = json_decode($json);

    // Get regular data
    $query = $conn->prepare('SELECT `companyName`, `address`, `contactPerson`, `email`, `phone` FROM `supplier` WHERE `supplierId` = :id');
    $query->bindParam(':id', $input->id);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        ':id' => $input->id,
        ':companyName' => $result[0]['companyName'],
        ':address' => $result[0]['address'],
        ':contactPerson' => $result[0]['contactPerson'],
        ':email' => $result[0]['email'],
        ':phone' => $result[0]['phone']
    ];

    // Check for changes
    foreach ($input as $key => $item) {
        if ($item != '') {
            $data[":$key"] = $item;
        }
    }

    // Insert new data
    $query = $conn->prepare(
        'UPDATE `supplier` SET
        `companyName` = :companyName,
        `address` = :address,
        `contactPerson` = :contactPerson,
        `email` = :email,
        `phone` = :phone
        WHERE `supplierId` = :id'
    );
    $query->execute($data);
    echo json_encode(["success" => true, "message" => "Supplier has been updated successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
