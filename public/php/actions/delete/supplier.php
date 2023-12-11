<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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