<?php
session_start();
include_once('../functions.php');

$conn = ConnectDB('root', '');

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
    $condition = "";
    $parameters = array();
    if (isset($_GET['id'])) {
        $condition = "WHERE customer.`customerId` = :id";
        $parameters = [":id" => $_GET['id']];
    }

    // Get customer data
    $query = $conn->prepare(
        'SELECT
        customer.`customerId`, customer.`firstName`, customer.`middleName`, customer.`lastName`, customer.`email`, customer.`phone`,customer.`address`, customer.`familyMemberAmount`, customer.`youngestPerson`,
        specifics.`specificId` AS specId, specifics.`desc`
        FROM customer
        LEFT JOIN customerspecifics
        ON customer.`customerId` = customerspecifics.`customerId`
        LEFT JOIN specifics
        ON customerspecifics.`specificId` = specifics.`specificId`
        ' . $condition . '
        ORDER BY customer.`customerId` DESC'
    );
    $query->execute($parameters);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Check if the table is not empty
    if (!empty($result)) {
        echo json_encode($result);
    } else {
        echo json_encode(["success" => false, "message" => "This table is empty"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
