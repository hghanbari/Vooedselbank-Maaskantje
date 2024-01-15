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

    // check if specifics exists
    $stmt = 'SELECT stockId FROM stock WHERE stockId = :stockId';
    $data = [':stockId' => $_POST["stock"]];
    if (!CheckIfExists($stmt, $data, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    $query = $conn->prepare("DELETE FROM packetStock WHERE stockId = :stockId");
    $query->bindParam(":stockId", $_POST["stock"]);
    $query->execute();

    $query = $conn->prepare("DELETE FROM stock WHERE stockId = :stockId");
    $query->bindParam(":stockId", $_POST["stock"]);
    $query->execute();
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
