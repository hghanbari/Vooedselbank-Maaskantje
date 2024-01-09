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
        LEFT JOIN customerSpecifics
        ON customer.`customerId` = customerSpecifics.`customerId`
        LEFT JOIN specifics
        ON customerSpecifics.`specificId` = specifics.`specificId`
        ' . $condition . '
        ORDER BY customer.`customerId` DESC'
    );
    $query->execute($parameters);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Check if the table is not empty
    if (!empty($result)) {
        $data = array();

        // foreach ($result as $customer) {
        //     $custId = $customer['custId'];
        //     $specId = $customer['specId'];

        //     // Create array key if not exists
        //     if (!array_key_exists($custId, $data)) {
        //         // Generic data
        //         $data[$custId] = [
        //             'customerId' => $custId,
        //             'firstName' => $customer['firstName'],
        //             'lastName' => $customer['lastName'],
        //             'email' => $customer['email'],
        //             'phone' => $customer['phone'],
        //             'familyMemberAmount' => $customer['familyMemberAmount'],
        //             'youngestPerson' => $customer['youngestPerson']
        //         ];
        //     }

        //     if ($specId != '') {
        //         if (!array_key_exists('specifics', $data[$custId])) {
        //             $data[$custId]['specifics'] = array();
        //         }

        //         $specData = [
        //             'specificId' => $specId,
        //             'specificDesc' => $customer['desc']
        //         ];
        //         array_push($data[$custId]['specifics'], $specData);
        //     }
        // }

        echo json_encode($result);
    } else {
        echo json_encode(["success" => false, "message" => "This table is empty"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
