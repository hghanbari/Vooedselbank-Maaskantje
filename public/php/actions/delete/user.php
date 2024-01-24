<?php
session_start();
include_once("../../functions.php");

$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    $userId = $_GET["id"];
    // check auth
    if (!CheckAuth(3, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    // check if user exists
    $stmt = 'SELECT userId FROM user WHERE userId = :userId';
    $data = [':userId' => $userId];
    if (!CheckIfExists($stmt, $data, $conn)) {
        echo json_encode(["success" => false, "message" => "User doesn't exist"]);
        exit();
    }

    // // Check password
    // $password = $conn->prepare("SELECT pass FROM user WHERE userId = :userId");
    // $password->bindParam(":userId", $userId);
    // $password->execute();

    // if (!password_verify($_POST["password"], $password[0]["pass"])) {
    //     header("Location: " . $_SERVER["HTTP_REFERER"]);
    //     exit();
    // }

    $query = $conn->prepare("DELETE FROM user WHERE userId = :userId");
    $query->bindParam(':userId', $userId);
    $query->execute();
    echo json_encode(["success" => true, "message" => "user has been deleted"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
