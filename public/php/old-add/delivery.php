<?php
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    if (!CheckAuth(3, $conn)) {
        // Return
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $data = [
        ':id' => hexdec(uniqid()),
        ':supplierId' => $_POST["supplier"],
        ':deliveryDate' => $_POST["deliveryDate"],
        ':deliveryTime' => $_POST["deliveryTime"]
    ];

    $query = $conn->prepare("INSERT INTO delivery (deliveryId, supplierId, deliveryDate, deliveryTime) 
    VALUES (:id, :supplierId, :deliveryDate, :deliveryTime)");
    $query->execute($data);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

?>