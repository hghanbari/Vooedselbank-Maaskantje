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

$json = file_get_contents('php://input');

// Converts it into a PHP object
$input = json_decode($json);



try {
    // Check auth
    if (empty($_SESSION["login"])) {
        echo json_encode(["success" => false, "message" => "User is not authorized"]);
        exit();
    }

    // get supplierId
    $query = $conn->prepare(
        "SELECT supplier.`supplierId` FROM supplier
        INNER JOIN delivery ON delivery.`supplierId` = supplier.`supplierId`
        WHERE delivery.`deliveryId` = :id
    "
    );

    $query->execute([':id' => $input->delivery]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        ':id' => GenerateUUID(),
        ':ean' => $input->ean,
        ':deliveryId' => $input->delivery,
        ':supplierId' => $result[0]['supplierId'],
        ':amount' => $input->amount,
        ':inUse' => 0,
        ':bestByDate' => $input->bestByDate
    ];

    $query->closeCursor();
    unset($query);
    unset($result);

    $query = $conn->prepare(
        "INSERT INTO stock (stockId, EAN, deliveryId, supplierId, amount, inUseAmount, bestByDate)
        VALUES (:id, :ean, :deliveryId, :supplierId, :amount, :inUse, :bestByDate)"
    );
    $query->execute($data);
    echo json_encode(["success" => true, "message" => "Product has been added successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
