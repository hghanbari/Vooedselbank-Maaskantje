<?php
session_start();
include_once('./functions.php');

$conn = ConnectDB('root', '');

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}

try {
    // Get account permissions
    if (isset($_SESSION['login'])) {
        $query = $conn->prepare('SELECT `auth` FROM `user` WHERE `userId` = :id');
        $query->execute([':id' => $_SESSION['login']]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            echo json_encode(['success' => false, 'message' => "No such user has been found"]);
            exit();
        }

        echo json_encode(['success' => true, 'auth' => $result[0]['auth']]);
    } else {
        echo json_encode(['success' => false, 'message' => "You are not logged in"]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}