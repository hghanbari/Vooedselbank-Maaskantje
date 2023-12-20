<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    if (!CheckAuth(3, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check for same email / phone
    $stmt = 'SELECT `email`, `phone` FROM `customer` WHERE `email` = :email OR `phone` = :phone';
    $data = [
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone']
    ];
    if (CheckIfExists($stmt, $data, $conn)) {
        echo "This email or phone already exists";

        // error cookie

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    unset($data);

    // Check what changed
    // Get default data
    $query = $conn->prepare('SELECT `firstName`, `lastName`, `email`, `phone`, `familyMemberAmount`, `youngestPerson` FROM `customer` WHERE `customerId` = :id');
    $query->bindParam(':id', $_POST['id']);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        ':id' => $_POST['id'],
        ':name' => $result[0]['firstName'],
        ':middleName' => isset($result[0]['middleName']) ? $result[0]['middleName'] : null,
        ':lastName' => $result[0]['lastName'],
        ':email' => $result[0]['email'],
        ':phone' => $result[0]['phone'],
        ':amount' => $result[0]['familyMemberAmount'],
        ':youngest' => $result[0]['youngestPerson']
    ];

    // Update data
    foreach ($_POST as $key=>$item) {
        if ($item != '' && $key != 'specifics') {
            $data[":$key"] = $item;
        }
    }

    // Execute w/ correct data
    $query = $conn->prepare(
        'UPDATE `customer` SET
        `firstName` = :name,
        `middleName` = :middleName,
        `lastName` = :lastName,
        `email` = :email,
        `phone` = :phone,
        `familyMemberAmount` = :amount,
        `youngestPerson` = :youngest
        WHERE `customerId` = :id'
    );
    $query->execute($data);

    // Check if specifics has changed
    if (!empty($_POST['specifics'])) {
        // Remove all specifics
        $query = $conn->prepare('DELETE FROM `customerspecifics` WHERE `customerId` = :custId');
        $query->bindParam(':custId', $_POST['id']);
        $query->execute();

        foreach ($_POST['specifics'] as $item) {
            $query = $conn->prepare('INSERT INTO `customerspecifics` (`customerId`, `specificId`) VALUE (:custId, :specId)');
            $query->bindParam(':custId', $_POST['id']);
            $query->bindParam(':specId', $item);
            $query->execute();
        }
    }    
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);