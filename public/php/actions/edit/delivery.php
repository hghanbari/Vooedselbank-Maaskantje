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
    $deliveryDate = $_POST["deliveryDate"];
    $deliveryTime = $_POST["deliveryTime"];
    $id = $_POST["id"];

    // Check auth
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if any field is filled in
    if ($_POST["deliveryDate"] == "" && $_POST["deliveryTime"] == "" && $_POST["delivered"] == "") {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // If more than one field is left empty query the database for that information
    if ($_POST["deliveryDate"] == "" || $_POST["deliveryTime"] == "" || $_POST["delivered"] == "") {
        $query = $conn->prepare("SELECT deliveryDate, deliveryTime, delivered FROM delivery WHERE deliveryId = :id");
        $data = [':id' => $id];
        $query->execute($data);
        $delivery = $query->fetchAll(PDO::FETCH_ASSOC);
    }    

    // Check if deliveryDate is set
    if ($_POST["deliveryDate"] == "") {
        $deliveryDate = $delivery[0]["deliveryDate"];
    }

    // Check if deliveryTime is set
    if ($_POST["deliveryTime"] == "") {
        $deliveryTime = $delivery[0]["deliveryTime"];
    }

    // If delivered is checked set it to 1 otherwise set it to 0
    if ($_POST["delivered"] == "") {
        $delivered = 0;
    } else {
        $delivered = 1;
    }

    $query = $conn->prepare("UPDATE delivery 
    SET deliveryDate = :deliveryDate, deliveryTime = :deliveryTime, delivered = :delivered 
    WHERE deliveryId = :id
    ");
    $query->bindParam(":deliveryDate", $deliveryDate);
    $query->bindParam(":deliveryTime", $deliveryTime);
    $query->bindParam(":delivered", $delivered);
    $query->bindParam(":id", $id);
    $query->execute();
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

?>