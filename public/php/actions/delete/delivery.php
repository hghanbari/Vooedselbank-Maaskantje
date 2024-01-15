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
    // Check auth
    if (empty($_SESSION["login"])) {
        echo json_encode(["success" => false, "message" => "User is not authorized"]);
        exit();
    }

    // Since you can only submit deliveries that haven't been submitted, there should be no stock
    // Just in case there is, this checks for it and doesn't delete delivery if there is
    $query = $conn->prepare('SELECT `stockId` FROM `stock` WHERE `deliveryId` = :id');
    $query->bindParam(':id', $_POST['delivery']);
    $query->execute();

    if (empty($query->fetchALL(PDO::FETCH_ASSOC))) {
        $conn->prepare('DELETE FROM `delivery` WHERE `deliveryId` = :id')->execute([':id' => $_POST['delivery']]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
