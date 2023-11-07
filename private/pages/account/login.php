<?php
require_once('../../initialize.php');

$conn = ConnectDB('root');

$email = $_POST['email'];
$pass = $_POST["pass"];
try {
    $stmt = $conn->prepare('SELECT `userId`, `email`, `pass` FROM `user` WHERE `email` = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch();

    $stmt->closeCursor();
    unset($stmt);

    if (password_verify($pass, $result['pass'])) {
        session_start();
        $_SESSION['loggedIn'] = $result['userId'];

        header('Location: ../../../public//staff/pages');
    } else {
        ReturnError("Incorrect email of wachtwoord", $_SERVER['HTTP_REFERER']);
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    ReturnError("Incorrect email of wachtwoord", $_SERVER['HTTP_REFERER']);
}