<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    if (!CheckAuth(1, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Split data
    $stockId = array();
    $ean = array();
    $amount = array();
    foreach ($_POST as $key=>$item) {
        if (strpos($key, '_item') === 0) {
            $values = explode("&", $item);
            array_push($stockId, $values[0]);
            array_push($ean, $values[1]);
        } else if (strpos($key, 'itemAmount') === 0) {
            array_push($amount, $item);
        }
    }

    // Delete data in DB
    $conn->prepare('DELETE FROM `packetstock` WHERE `packetId` = :id')->execute([':id' => $_POST['packet']]);

    // Insert data into DB
    $query = $conn->prepare(
        'INSERT INTO `packetstock`
        (`packetId`, `customerId`, `stockId`, `EAN`, `amount`)
        VALUES (:packetId, :customerId, :stockId, :ean, :amount)'
    );

    foreach ($stockId as $i=>$stock) {
        $data = [
            ':packetId' => $_POST['packet'],
            ':customerId' => $_POST['customer'],
            ':stockId' => $stock,
            ':ean' => $ean[$i],
            ':amount' => $amount[$i]
        ];
        
        $query->execute($data);
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);