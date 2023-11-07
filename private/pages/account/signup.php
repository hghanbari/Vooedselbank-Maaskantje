<?php
require_once('../../initialize.php');

$conn = ConnectDB("root");

// Check if the user has the authority to add people
try {
    if (isset($_SESSION['loggedIn'])) {
        $stmt = $conn->prepare('SELECT `auth` FROM user WHERE `userId` = :id');
        $stmt->bindParam(':id', $_SESSION['loggedIn']);
        $stmt->execute();
        $result = $stmt->fetch();

        if ((int)$result['auth'] !== 3) {
            ReturnError("Incorrecte autoriteit om deze actie uit te voeren", $_SERVER['HTTP_REFERER']);
        }
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    ReturnError("Incorrecte autoriteit om deze actie uit te voeren", $_SERVER['HTTP_REFERER']);
}

// If they past this check it enters the user into the database
$userData = [
    ':id' => hexdec(uniqid()),
    ':name' => $_POST['name'],
    ':lastName' => $_POST['lastname'],
    ':pass' => password_hash('12345678', PASSWORD_BCRYPT),
    ':email' => $_POST['email'],
    ':phone' => $_POST['phone'],
    ':adress' => $_POST['adres'],
    ':auth' => $_POST['auth']
];

try {
    // Check if the email exists
    $stmt = $conn->prepare('SELECT `email` FROM `user` WHERE `email` = :email');
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    $result = $stmt->fetch();

    $stmt->closeCursor();
    unset($stmt);
    if ($result->rowCount() > 0) {
        ReturnError("Deze email is al ingebruik", $_SERVER['HTTP_REFERER']);
    }

    // Insert into database
    $stmt = $conn->prepare('INSERT INTO `user` 
        (`userId`, `name`, `lastName`, `pass`, `email`, `phone`, `adress`, `auth`)
        VALUES (:id, :name, :lastName, :pass, :email, :phone, :adress, :auth)');
    $stmt->execute($userData);

    $stmt->closeCursor();

    header('Location: ' . $_SERER['HTTP_REFERER']);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    ReturnError("Er ging iets fout, probeer het later opnieuw", $_SERVER['HTTP_REFERER']);
}