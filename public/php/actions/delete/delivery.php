<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Since you can only submit deliveries that haven't been submitted, there should be no stock
    // Just in case there is, this checks for it and doesn't delete delivery if there is
    $query = $conn->prepare('SELECT `stockId` FROM `stock` WHERE `deliveryId` = :id');
    $query->bindParam(':id', $_POST['delivery']);
    $query->execute();

    if (empty($query->fetchALL(PDO::FETCH_ASSOC))) {
        $conn->prepare('DELETE FROM `delivery` WHERE `deliveryId` = :id')->execute([':id' => $_POST['delivery']]);
    }
} catch (PDOException $e) {
    echo "Error1: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);