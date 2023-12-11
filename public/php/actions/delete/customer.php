<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Delete all children
    $conn->prepare('DELETE FROM `packetstock` WHERE `customerId` = :id')->execute([':id' => $_POST['customer']]);
    $conn->prepare('DELETE FROM `packet` WHERE `customerId` = :id')->execute([':id' => $_POST['customer']]);
    $conn->prepare('DELETE FROM `customerspecifics` WHERE `customerId` = :id')->execute([':id' => $_POST['customer']]);

    // Delete customer
    $conn->prepare('DELETE FROM `customer` WHERE `customerId` = :id')->execute([':id' => $_POST['customer']]);
    
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);