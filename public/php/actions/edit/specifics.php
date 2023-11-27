<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    // Check auth
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Update if changed
    if ($_POST['desc'] != '') {
        $data = [
            ':id' => $_POST['id'],
            ':desc' => $_POST['desc']
        ];

        $query = $conn->prepare('UPDATE `specifics` SET `desc` = :desc WHERE `specificId` = :id');
        $query->execute($data);
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);