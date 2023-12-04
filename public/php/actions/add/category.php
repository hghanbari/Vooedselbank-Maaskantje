<?php
include_once("../../functions.php");

// Connect DB
$conn = ConnectDB("root", "");

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