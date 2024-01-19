<?php
session_start();
include_once('../functions.php');

$conn = ConnectDB('root', '');

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    // Get customer data
    $query = $conn->prepare(
        "SELECT stock.`EAN`, products.`name`, stock.`stockId` FROM `stock`
        INNER JOIN products
        ON stock.EAN = products.EAN
        ");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Check if the table is not empty
    if (!empty($result)) {
        // $data = array();

        echo json_encode($result);
    } else {
        echo json_encode(["success" => false, "message" => "This table is empty"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
