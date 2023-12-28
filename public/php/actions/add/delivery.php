<?php
session_start();
include_once("../../functions.php");

$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    // Check auth
    if (empty($_SESSION["login"])) {
        echo json_encode(["success" => false, "message" => "User is not authorized"]);
        exit();
    }

    $data = [
        ':id' => GenerateUUID(),
        ':supplierId' => $_POST["supplier"],
        ':deliveryDate' => $_POST["deliveryDate"],
        ':deliveryTime' => $_POST["deliveryTime"]
    ];

    $query = $conn->prepare("INSERT INTO delivery (deliveryId, supplierId, deliveryDate, deliveryTime) 
    VALUES (:id, :supplierId, :deliveryDate, :deliveryTime)");
    $query->execute($data);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
