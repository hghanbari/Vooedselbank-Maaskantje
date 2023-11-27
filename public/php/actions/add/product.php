<?php
include_once('../../functions.php');

// Connect DB
$conn = ConnectDB("root", "");

try {
    if (!CheckAuth(2, $conn)) {
        // Return
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Insert into DB
    // If EAN is not entered use auto ID
    $ean = $_POST['EAN'];
    if ($ean == "") {
        $ean = hexdec(uniqid());
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
    ];

    $query = $conn->prepare(
        'INSERT INTO `products` (`EAN`, `catagoryId`, `productAge`)
        VALUES (:ean, :catagoryId, :productAge);'
    );
    $query->execute($data);

    // Add specifics
    if (!in_array('nothing', $_POST['specifics'])) {
        foreach ($_POST['specifics'] as $specific) {
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