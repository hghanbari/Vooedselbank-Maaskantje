<?php
include_once("../../functions.php");

// Connect DB
$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    // Check auth
    if (!CheckAuth(2, $conn)) {
        // Return
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $query = $conn->prepare('INSERT INTO `catagory` (`catagoryId`, `desc`) VALUE (:id, :desc)');
    $query->bindParam(':id', GenerateUUID());
    $query->bindParam(':desc', $_POST['desc']);
    $query->execute();
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Error cookie
}
header('Location: ' . $_SERVER['HTTP_REFERER']);