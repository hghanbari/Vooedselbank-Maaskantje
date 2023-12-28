<?php
session_start();
include_once('../../functions.php');

// Connect DB
$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    // Check auth
    if (empty($_SESSION["login"])) {
        echo json_encode(["success" => false, "message" => "User is not authorized"]);
        exit();
    }

    // Insert into DB
    // If EAN is not entered use auto ID
    $ean = $_POST['EAN'];
    if ($ean == "") {
        $ean = GenerateUUID();
    }

    $stmt = 'SELECT `EAN` FROM `products` WHERE `EAN` = :ean';
    $data = [':ean' => $ean];
    if (CheckIfExists($stmt, $data, $conn)) {
        // EAN exists
        // Error cookie
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    unset($data);

    $data = [
        ':ean' => $ean,
        ':catagoryId' => $_POST['catagory'],
        ':productAge' => $_POST['age'],
        ':name' => $_POST['name']
    ];

    $query = $conn->prepare(
        'INSERT INTO `products` (`EAN`, `catagoryId`, `productAge`, `name`)
        VALUES (:ean, :catagoryId, :productAge, :name);'
    );
    $query->execute($data);

    // Add specifics
    if (isset($_POST['specifics[]']) && !in_array('nothing', $_POST['specifics[]'])) {
        foreach ($_POST['specifics[]'] as $specific) {
            $data = [
                ':specificId' => $specific,
                ':ean' => $ean
            ];

            $query = $conn->prepare(
                'INSERT INTO `specificsforproducts` (`specificId`, `EAN`)
                VALUES (:specificId, :ean)'
            );
            $query->execute($data);
        }
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Create error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
