<?php
session_start();
include_once("../../functions.php");

$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}

try {
    $stockId = $_GET["id"];
    // Check auth
    if (empty($_SESSION["login"])) {
        echo json_encode(["success" => false, "message" => "User is not authorized"]);
        exit();
    }

    // check if specifics exists
    $stmt = 'SELECT stockId FROM stock WHERE stockId = :stockId';
    $data = [':stockId' => $stockId];
    if (!CheckIfExists($stmt, $data, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    $query = $conn->prepare("DELETE FROM packetstock WHERE stockId = :stockId");
    $query->bindParam(":stockId", $stockId);
    $query->execute();

    $query = $conn->prepare("DELETE FROM stock WHERE stockId = :stockId");
    $query->bindParam(":stockId", $stockId);
    $query->execute();

    echo json_encode(["success" => true, "message" => "Product has been deleted"]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
