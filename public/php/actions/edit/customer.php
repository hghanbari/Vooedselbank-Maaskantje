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

    // Check what changed
    // Get default data
    $query = $conn->prepare('SELECT `firstName`, `lastName`, `email`, `phone`,`address`, `familyMemberAmount`, `youngestPerson` FROM `customer` WHERE `customerId` = :id');
    $query->bindParam(':id', $input->id);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        ':id' => $input->id,
        ':firstName' => $result[0]['firstName'],
        ':middleName' => isset($result[0]['middleName']) ? $result[0]['middleName'] : null,
        ':lastName' => $result[0]['lastName'],
        ':email' => $result[0]['email'],
        ':phone' => $result[0]['phone'],
        ':address' => $result[0]['address'],
        ':amount' => $result[0]['familyMemberAmount'],
        ':youngest' => $result[0]['youngestPerson']
    ];

    // Update data
    foreach ($input as $key => $item) {
        if ($item != '' && $key != 'specifics') {
            $data[":$key"] = $item;
        }
    }

    // Execute w/ correct data
    $query = $conn->prepare(
        'UPDATE `customer` SET
        `firstName` = :firstName,
        `middleName` = :middleName,
        `lastName` = :lastName,
        `email` = :email,
        `address`= :address,
        `phone` = :phone,
        `familyMemberAmount` = :amount,
        `youngestPerson` = :youngest
        WHERE `customerId` = :id'
    );
    $query->execute($data);


    echo json_encode(["success" => true, "message" => "Customer has been updated successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
