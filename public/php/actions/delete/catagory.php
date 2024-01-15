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
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
