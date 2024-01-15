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


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}

try {

    $condition = "";
    $parameters = array();
    if (isset($_GET['id'])) {
        $condition = "WHERE customer.`customerId` = :id";
        $parameters = [":id" => $_GET['id']];
    }

    $query = $conn->prepare(
        "SELECT packet.packetId, packet.customerId, packet.makeDate, packet.pickUpDate, customer.firstName, customer.lastName, packetstock.stockId, packetstock.EAN, packetstock.amount, products.name AS productName FROM packet
        LEFT JOIN customer
        ON packet.customerId = customer.customerId
        LEFT JOIN packetstock
        ON packetstock.packetId = packet.packetId
        LEFT JOIN products
        ON packetstock.EAN = products.EAN
        " . $condition
    );

    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $data = [];
        foreach ($result as $packet) {
            $packetId = $packet["packetId"];


            if (!array_key_exists($packetId, $data)) {
                $data[$packetId] = [
                    'packetId' => $packetId,
                    'customer' => [
                        'customerId' => $packet["customerId"],
                        'customerName' => $packet["firstName"],
                        'customerLastName' => $packet["lastName"]
                    ],
                    'makeDate' => $packet["makeDate"],
                    'pickUpDate' => $packet["pickUpDate"]
                ];
            }

            if ($packet["EAN"] != "") {
                if (!array_key_exists('products', $data[$packetId])) {
                    $data[$packetId]['products'] = array();
                }

                $productData = [
                    'EAN' => $packet["EAN"],
                    'amount' => $packet["amount"],
                    'productName' => $packet["productName"]
                ];
                array_push($data[$packetId]['products'], $productData);
            }
        }


        echo json_encode($data);
    } else {
        echo json_encode(["success" => true, "message" => "This table is empty"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
