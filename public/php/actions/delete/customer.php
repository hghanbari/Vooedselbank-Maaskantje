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

try {
    $customer_id = $_GET["id"];
    // Check auth
    if (empty($_SESSION["login"])) {
        echo json_encode(["success" => false, "message" => "User is not authorized"]);
        exit();
    }

    // Delete all children
    $conn->prepare('DELETE FROM `packetstock` WHERE `customerId` = :id')->execute([':id' => $customer_id]);
    $conn->prepare('DELETE FROM `packet` WHERE `customerId` = :id')->execute([':id' => $customer_id]);
    $conn->prepare('DELETE FROM `customerspecifics` WHERE `customerId` = :id')->execute([':id' => $customer_id]);

    // Delete customer
    $conn->prepare('DELETE FROM `customer` WHERE `customerId` = :id')->execute([':id' => $customer_id]);

    echo json_encode(["success" => true, "message" => "Customer has been deleted successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
