<?php
include_once("../../functions.php");

// Connect to DB
$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    // Check auth
    if (!CheckAuth(3, $conn)) {
        // Send user back to previous page
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

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    unset($data);

    // Insert into DB
    $id = hexdec(uniqid());
    $data = [
        ':id' => $id,
        ':name' => $_POST['name'],
        ':lastName' => $_POST['lastName'],
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone'],
        ':amount' => $_POST['amount'],
        ':age' => $_POST['youngest']
    ];

    $query = $conn->prepare(
        'INSERT INTO `customer`
        (`customerId`, `name`, `lastName`, `email`, `phone`, `familyMemberAmount`, `youngestPerson`)
        VALUES (:id, :name, :lastName, :email, :phone, :amount, :age)'
    );
    $query->execute($data);

    if (!in_array('nothing', $_POST['specifics'])) {
        foreach ($_POST['specifics'] as $specific) {
            $data = [
                ':specificId' => $specific,
                ':customerId' => $id
            ];
    
            $query = $conn->prepare(
                'INSERT INTO `customerspecifics` (`specificId`, `customerId`)
                VALUES (:specificId, :customerId)'
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
