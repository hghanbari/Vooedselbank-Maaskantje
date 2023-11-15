<?php
include("../functions.php");

// Connect to DB
$conn = ConnectDB("root", "");

// Checks for email & phone
try {
    // Since we still need to create a user, this'll be commented out
    
    // Check for admin status
    /*$query = $conn->prepare('SELECT `auth` FROM `user` WHERE `userId` = :id');
    $query->bindParam(':id', $_SESSION['login']);
    $query->execute();

    $result = $query->fetchAll();

    if ($result[0] !== 3) {
        // User is not admin
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }*/

    // Query DB
    $query = $conn->prepare('SELECT `email`, `phone` FROM `user` WHERE `email` = :email OR `phone` = :phone');
    $query->bindParam(':email', $_POST['email']);
    $query->bindParam(':phone', $_POST['phone']);
    $query->execute();

    $result = $query->fetchAll();

    if (!empty($result)) {
        // Create error cookie

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Cleanup
    $query->closeCursor();
    unset($query);
    unset($result);

    // Insert new user into db
    // Get data
    $data = [
        ':id' => hexdec(uniqid()),
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
        (`userId`, `name`, `lastName`, `pass`, `email`, `phone`, `adress`, `auth`)
        VALUES (:id, :name, :lastName, :pass, :email, :phone, :adress, :auth)
        ');
    $query->execute($data);

    echo "Added to DB";

    // Cleanup
    $query->closeCursor();
    unset($query);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Create error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);