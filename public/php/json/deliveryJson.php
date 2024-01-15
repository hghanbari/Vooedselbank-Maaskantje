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

    $condition = "";
    $parameters = array();
    if (isset($_GET['id'])) {
        $condition = "WHERE customer.`customerId` = :id";
        $parameters = [":id" => $_GET['id']];
    }

    $query = $conn->prepare("SELECT deliveryId, supplierId, deliveryDate, deliveryTime, delivered FROM delivery" . $condition);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $data = [];
        foreach ($result as $delivery) {
            $data[$delivery["deliveryId"]] = [
                'deliveryId' => $delivery["deliveryId"],
                'supplierId' => $delivery["supplierId"],
                'deliveryDate' => $delivery["deliveryDate"],
                'deliveryTime' => $delivery["deliveryTime"],
                'delivered' => $delivery["delivered"]
            ];
        }

        echo json_encode($data);
    } else {

        echo json_encode(["success" => true, "message" => "This table is empty"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
