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
    $supplier_id = $_GET["id"];
    // Check auth
    if (empty($_SESSION["login"])) {
        echo json_encode(["success" => false, "message" => "User is not authorized"]);
        exit();
    }

    // check if supplier exists in deliveries
    $stmt = 'SELECT supplierId FROM delivery WHERE supplierId = :supplierId';
    $data = [':supplierId' => $supplier_id];
    if (CheckIfExists($stmt, $data, $conn)) {
        // throw error
        echo json_encode(["success" => true, "message" => "Error: There is an active delivery."]);
        exit();
    }

    $query = $conn->prepare("DELETE FROM supplier WHERE supplierId = :supplierId");
    $query->bindParam(":supplierId", $supplier_id);
    $query->execute();

    echo json_encode(["success" => true, "message" => "Supplier has been deleted successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
