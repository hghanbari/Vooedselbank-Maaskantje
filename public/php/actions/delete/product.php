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

    // Check if product is already in use
    $query = $conn->prepare('SELECT `EAN` FROM `stock` WHERE `EAN` = :ean');
    $query->bindParam(':ean', $_POST['product']);
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Delete product
    $conn->prepare('DELETE FROM `products` WHERE `EAN` = :ean')->execute([':ean' => $_POST['product']]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
