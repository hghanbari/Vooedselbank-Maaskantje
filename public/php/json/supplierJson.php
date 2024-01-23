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
        $condition = "WHERE supplier.`supplierId` = :id";
        $parameters = [":id" => $_GET['id']];
    }

    $json = file_get_contents('php://input');

    // Converts it into a PHP object
    $input = json_decode($json);

    $query = $conn->prepare("SELECT supplierId, companyName, address, contactPerson, email, phone FROM supplier " . $condition);
    $query->execute($parameters);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {

        echo json_encode($result);
    } else {
        echo json_encode(["success" => false, "message" => "This table is empty"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
