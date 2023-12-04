<?php
include("../functions.php");

// Connect to DB
$conn = ConnectDB("root", "");

try {
    // Since we still need to create a user, this'll be commented out
    
    // Check for admin status
    if (!CheckAuth(3, $conn)) {
        // Create error cookie

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check for email and phone
    $stmt = 'SELECT `email`, `phone` FROM `user` WHERE `email` = :email OR `phone` = :phone';
    $data = [
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone']
    ];
    if (CheckIfExists($stmt, $data, $conn)) {
        // Create error cookie

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Insert new user into db
    // Get data
    $data = [
        ':id' => GenerateUUID(),
        ':name' => $_POST['name'],
        ':lastName' => $_POST['lastName'],
        ':pass' => password_hash('12345678', PASSWORD_BCRYPT),
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone'],
        ':adress' => $_POST['adress'],
        ':auth' => $_POST['auth']
    ];

    // Query DB
    $query = $conn->prepare
        ('INSERT INTO `user`
        (`userId`, `firstName`, `lastName`, `pass`, `email`, `phone`, `adress`, `auth`)
        VALUES (:id, :name, :lastName, :pass, :email, :phone, :adress, :auth)
        ');
    $query->execute($data);

    $query->closeCursor();
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Create error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);