<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    // Check auth
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Get unchanged data
    $query = $conn->prepare('SELECT `EAN`, `amount`, `inUseAmount`, `bestByDate` FROM `stock` WHERE `stockId` = :id');
    $query->bindParam(':id', $_POST['stock']);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    $data = [
        ':stock' => $result['stockId'],
        ':product' => $result['EAN'],
        ':amount' => $result['amount'],
        ':inUse' => $result['inUseAmount'],
        ':bestBy' => $result['bestByDate']
    ];

    // Alter data
    foreach ($_POST as $key=>$item) {
        if ($item != '') {
            $data[":$key"] = $item;
            if ($key == 'product' && $item == 'same') {
                $data[':product'] = $result['EAN'];
            }
        }
    }

    // Input data
    $query = $conn->prepare('UPDATE `stock` SET `EAN` = :product, `amount` = :amount, `inUseAmount` = :inUse, `bestByDate` = :bestBy WHERE `stockId` = :stock');
    $query->execute($data);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);