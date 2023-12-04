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
    $stmt = 'SELECT specificId FROM specifics WHERE specificId = :specificId';
    $data = [':specificId' => $_POST["specifics"]];
    if (!CheckIfExists($stmt, $data, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    $query = $conn->prepare("DELETE FROM specifics WHERE specificId = :specificId");
    $query->bindParam("specificId", $_POST["specifics"]);
    $query->execute();

} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>