<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if product is already in use
    $query = $conn->prepare('SELECT `EAN` FROM `stock` WHERE `EAN` = :ean');
    $query->bindParam(':ean', $_POST['product']);
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Delete product
    $conn->prepare('DELETE FROM `products` WHERE `EAN` = :ean')->execute([':ean' => $_POST['product']]);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);