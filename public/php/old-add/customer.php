<?php
session_start();
include_once("../../functions.php");

// Connect to DB
$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}


try {
    // Check auth
    if (!CheckAuth(3, $conn)) {
        // Send user back to previous page
        // header('Location: ' . $_SERVER['HTTP_REFERER']);
        // exit();
    }

    // Check for same email / phone
    $stmt = 'SELECT `email`, `phone` FROM `customer` WHERE `email` = :email';
    $data = [
        ':email' => $_POST['email'],

    ];
    if (CheckIfExists($stmt, $data, $conn)) {
        echo json_encode(["success" => false, "message" => "This email or phone already exists"]);

        // header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    unset($data);

    // Insert into DB
    $id = hexdec(uniqid());
    $data = [
        ':id' => $id,
        ':firstName' => $_POST['firstName'],
        ':middleName' => $_POST['middleName'],
        ':lastName' => $_POST['lastName'],
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone'],
        ':amount' => $_POST['amount'],
        ':age' => $_POST['youngest']
    ];

    $query = $conn->prepare(
        'INSERT INTO `customer`
        (`customerId`, `firstName`, `middleName` `lastName`, `email`, `phone`, `familyMemberAmount`, `youngestPerson`)
        VALUES (:id, :firstName,:middleName, :lastName, :email, :phone, :amount, :age)'
    );
    $query->execute($data);

    if (!in_array('nothing', $_POST['specifics'])) {
        foreach ($_POST['specifics'] as $specific) {
            $data = [
                ':specificId' => $specific,
                ':customerId' => $id
            ];

            $query = $conn->prepare(
                'INSERT INTO `customerspecifics` (`specificId`, `customerId`)
                VALUES (:specificId, :customerId)'
            );
            $query->execute($data);
        }
    }
    echo json_encode(["success" => true]);
} catch (PDOException $e) {

    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit();
}
