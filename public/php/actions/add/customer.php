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

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}

$json = file_get_contents('php://input');

// Converts it into a PHP object
$input = json_decode($json);


try {
    // // Check auth
    // if (!CheckAuth(3, $conn)) {
    //     // Send user back to previous page
    //     header('Location: ' . $_SERVER['HTTP_REFERER']);
    //     exit();
    // }

    // // Check for same email / phone
    // $stmt = 'SELECT `email`, `phone` FROM `customer` WHERE `email` = :email OR `phone` = :phone';
    // $data = [
    //     ':email' => $input->email,
    //     ':phone' => $input->phone
    // ];
    // if (CheckIfExists($stmt, $data, $conn)) {
    //     echo "This email or phone already exists";

    //     header('Location: ' . $_SERVER['HTTP_REFERER']);
    //     exit();
    // }
    // unset($data);

    // Insert into DB
    $id = GenerateUUID();
    $data = [
        ':id' => $id,
        ':name' => $input->firstName,
        ':middleName' => $input->middleName,
        ':lastName' => $input->lastName,
        ':email' => $input->email,
        ':phone' => $input->phone,
        ':amount' => $input->famAmount,
        ':age' => $input->age
    ];

    $query = $conn->prepare(
        'INSERT INTO `customer`
        (`customerId`, `firstName`, `middleName`, `lastName`, `email`, `phone`, `familyMemberAmount`, `youngestPerson`)
        VALUES (:id, :name, :middleName, :lastName, :email, :phone, :amount, :age)'
    );
    $query->execute($data);

    // if (isset($_POST['specifics']) && !in_array('nothing', $_POST['specifics'])) {
    //     foreach ($_POST['specifics'] as $specific) {
    //         $data = [
    //             ':specificId' => $specific,
    //             ':customerId' => $id
    //         ];
    
    //         $query = $conn->prepare(
    //             'INSERT INTO `customerspecifics` (`specificId`, `customerId`)
    //             VALUES (:specificId, :customerId)'
    //         );
    //         $query->execute($data);
    //     }
    // }
    // $data = [
    //     ':specificId' => $input->specifics,
    //     ':customerId' => $id
    // ];

    // $query = $conn->prepare(
    //     'INSERT INTO `customerSpecifics` (specificId, customerId)
    //     VALUES (:specificId, :customerId)'
    // );
    // $query->execute($data);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Create error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
