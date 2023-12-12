<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    // check auth
    if (!CheckAuth(3, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    // Check if specific is in use
    $prod = $conn->prepare('SELECT `specificId` FROM `specificsforproducts` WHERE `specificId` = :id');
    $prod->execute([':id' => $_POST['specifics']]);
    $cust = $conn->prepare('SELECT `specificId` FROM `customerspecifics` WHERE `specificId` = :id');
    $cust->execute([':id' => $_POST['specifics']]);
    if ($prod->rowCount() > 0 || $cust->rowCount() > 0) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $query = $conn->prepare("DELETE FROM specifics WHERE specificId = :specificId");
    $query->bindParam("specificId", $_POST["specifics"]);
    $query->execute();
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>