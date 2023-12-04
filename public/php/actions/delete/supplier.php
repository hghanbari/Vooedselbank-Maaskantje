<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    // check auth
    if (!CheckAuth(3, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    // check if supplier exists in deliveries
    $stmt = 'SELECT supplierId FROM delivery WHERE supplierId = :supplierId';
    $data = [':supplierId' => $_POST["supplier"]];
    if (CheckIfExists($stmt, $data, $conn)) {
        // throw error
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    $query = $conn->prepare("DELETE FROM supplier WHERE supplierId = :supplierId");
    $query->bindParam(":supplierId", $_POST["supplier"]);
    $query->execute();


} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>