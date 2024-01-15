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

    // Check if specific is in use
    $prod = $conn->prepare('SELECT `specificId` FROM `specificsforproducts` WHERE `specificId` = :id');
    $prod->execute([':id' => $_POST['specifics']]);
    $cust = $conn->prepare('SELECT `specificId` FROM `customerspecifics` WHERE `specificId` = :id');
    $cust->execute([':id' => $_POST['specifics']]);
    if ($prod->rowCount() > 0 || $cust->rowCount() > 0) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $query = $conn->prepare("DELETE FROM specifics WHERE specificId = :specificId");
    $query->bindParam("specificId", $_POST["specifics"]);
    $query->execute();
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
