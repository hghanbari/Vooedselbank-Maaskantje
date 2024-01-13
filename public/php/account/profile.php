<?php
session_start();
include_once("../functions.php");

// connect to database
$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    $userId = $_SESSION["login"];
    // Get user data
    $query = $conn->prepare(
        'SELECT * FROM user WHERE userId = :userId'
    );
    $query->execute([':userId' => $userId]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        echo json_encode($result);
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
