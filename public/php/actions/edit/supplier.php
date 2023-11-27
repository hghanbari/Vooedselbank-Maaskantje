<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    if (!CheckAuth(3, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Get regular data
    $query = $conn->prepare('SELECT `companyName`, `adress`, `contactName`, `email`, `phone` FROM `supplier` WHERE `supplierId` = :id');
    $query->bindParam(':id', $_POST['id']);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    $data = [
        ':id' => $_POST['id'],
        ':companyName' => $result['companyName'],
        ':adress' => $result['adress'],
        ':contactName' => $result['contactName'],
        ':email' => $result['email'],
        ':phone' => $result['phone']
    ];

    // Check for changes
    foreach ($_POST as $key=>$item) {
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