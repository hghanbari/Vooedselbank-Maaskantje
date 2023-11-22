<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    if ($_POST['desc'] == '') {
        // Cookie that says nothing changed

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $query = $conn->prepare('UPDATE `catagory` SET `desc` = :desc WHERE `catagoryId` = :id');
    $query->bindParam(':desc', $_POST['desc']);
    $query->bindParam('id', $_POST['id']);
    $query->execute();
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);