<?php
// Als je hier bent het catagory niet update, 
// het komt omdat de database NULL niet exepteert wanneer je 'none' kiest.
// Dit kan je fixen door de default van 'catagoryId' op NULL te zetten

include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check what changed
    // Get default data
    $query = $conn->prepare('SELECT `catagoryId`, `productAge`, `name` FROM `products` WHERE `EAN` = :ean');
    $query->bindParam(':ean', $_POST['ean']);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        ':ean' => $_POST['ean'],
        ':catagory' => $result[0]['catagoryId'],
        ':age' => $result[0]['productAge'],
        ':name' => $result[0]['name']
    ];

    // Update data
    foreach ($_POST as $key=>$item) {
        if ($item != '') {
            $data[":$key"] = $item;
        }

        if ($key == 'catagory' && $item == 'none') {
            $data[":$key"] = null;
        }
    }

    // Insert data
    $query = $conn->prepare('UPDATE `products` SET `catagoryId` = :catagory, `productAge` = :age, `name` = :name WHERE `EAN` = :ean');
    $query->execute($data);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);