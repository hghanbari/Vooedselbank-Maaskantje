<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

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