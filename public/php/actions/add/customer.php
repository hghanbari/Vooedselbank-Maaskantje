<?php
include_once("../../functions.php");

// Connect to DB
$conn = ConnectDB("root", "");

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
    $data = [
        ':id' => hexdec(uniqid()),
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

    $query->closeCursor();
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Create error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);