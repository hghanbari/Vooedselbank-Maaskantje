<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if catagory is used
    $query = $conn->prepare('SELECT `EAN` FROM `products` WHERE `catagoryId` = :id');
    $query->bindParam(':id', $_POST['catagory']);
    $query->execute();

    // Nothing uses this catagory
    if (empty($query->fetchAll(PDO::FETCH_ASSOC))) {
        $query = $conn->prepare('DELETE FROM `catagory` WHERE `catagoryId` = :id');
        $query->bindParam(':id', $_POST['catagory']);
        $query->execute();
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);