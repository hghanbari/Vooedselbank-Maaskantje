<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    // check auth
    if (!CheckAuth(3, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    // check if specifics exists
    $stmt = 'SELECT stockId FROM stock WHERE stockId = :stockId';
    $data = [':stockId' => $_POST["stock"]];
    if (!CheckIfExists($stmt, $data, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    $query = $conn->prepare("DELETE FROM packetStock WHERE stockId = :stockId");
    $query->bindParam(":stockId", $_POST["stock"]);
    $query->execute();

    $query = $conn->prepare("DELETE FROM stock WHERE stockId = :stockId");
    $query->bindParam(":stockId", $_POST["stock"]);
    $query->execute();


} catch (PDOException $e) {
echo "Error!: " . $e->getMessage();
}
?>