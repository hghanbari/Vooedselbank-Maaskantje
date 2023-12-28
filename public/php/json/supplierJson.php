<?php
session_start();
include_once("../functions.php");

$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {

    $query = $conn->prepare("SELECT supplierId, companyName, address, contactName, email, phone FROM supplier");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $data = [];
        foreach ($result as $supplier) {
            $data[$supplier["supplierId"]] = [
                'supplierId' => $supplier["supplierId"],
                'companyName' => $supplier["companyName"],
                'address' => $supplier["address"],
                'contactName' => $supplier["contactName"],
                'email' => $supplier["email"],
                'phone' => $supplier["phone"]
            ];
        }
        header('Content-Type: application/json');

        echo json_encode($data);
    } else {
        echo "This table is empty";
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
