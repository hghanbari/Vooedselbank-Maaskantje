<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    if (!CheckAuth(1, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // The query should only get the items that have yet to be picked up
    // Just in case something weird happend this will check if the date has passed
    $query = $conn->prepare('SELECT `pickUpDate` FROM `packet` WHERE `packetId` = :id');
    $query->bindParam(':id', $_POST['packet']);
    $query->execute();

    if ($query->fetchAll(PDO::FETCH_ASSOC) > new DateTime()) {
        // It is somehow in the past
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Update stock
    $query = $conn->prepare('SELECT `stockId`, `amount` FROM `packetstock` WHERE `packetId` = :id');
    $query->execute([':id' => $_POST['packet']]);
    $stock = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($stock as $item) {
        $query = $conn->prepare('UPDATE `stock` SET `inUseAmount` = `inUseAmount` - :amount WHERE `stockId` = :id');
        $query->bindParam(':amount', $item['amount']);
        $query->bindParam(':id', $item['stockId']);
        $query->execute();
    }

    // Delete children
    $conn->prepare('DELETE FROM `packetStock` WHERE `packetId` = :id')->execute([':id' => $_POST['packet']]);
    
    // Delete packet
    $conn->prepare('DELETE FROM `packet` WHERE `packetId` = :id')->execute([':id' => $_POST['packet']]);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
//header('Location: ' . $_SERVER['HTTP_REFERER']);