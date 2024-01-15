<?php
session_start();
include_once('../functions.php');

$conn = ConnectDB('root', '');

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    // Get product data
    $query = $conn->prepare("SELECT `EAN`, `name` FROM `products`");
    $query->execute();
    $products = $query->fetchAll(PDO::FETCH_ASSOC);

    // Get delivery data
    $query = $conn->prepare(
        "SELECT delivery.deliveryId, supplier.companyName, delivery.deliveryDate FROM `delivery`
        INNER JOIN `supplier`
        ON supplier.supplierId = delivery.supplierId"
    );
    $query->execute();
    $delivery = $query->fetchAll(PDO::FETCH_ASSOC);

    // Check if the table is not empty
    if (!empty($products)) {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $obj = [
            'products' => $products,
            'delivery' => $delivery,
        ];

        echo json_encode($obj);
    } else {
        echo json_encode(["success" => true, "message" => "This table is empty"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
