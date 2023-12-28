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
    if (!CheckAuth(3, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Get regular data
    $query = $conn->prepare('SELECT `companyName`, `address`, `contactName`, `email`, `phone` FROM `supplier` WHERE `supplierId` = :id');
    $query->bindParam(':id', $_POST['id']);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    $data = [
        ':id' => $_POST['id'],
        ':companyName' => $result['companyName'],
        ':address' => $result['address'],
        ':contactName' => $result['contactName'],
        ':email' => $result['email'],
        ':phone' => $result['phone']
    ];

    // Check for changes
    foreach ($_POST as $key => $item) {
        if ($item != '') {
            $data[":$key"] = $item;
        }
    }

    // Insert new data
    $query = $conn->prepare(
        'UPDATE `supplier` SET
        `companyName` = :companyName,
        `adress` = :adress,
        `contactName` = :contactName,
        `email` = :email,
        `phone` = :phone
        WHERE `supplierId` = :id'
    );
    $query->execute($data);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
