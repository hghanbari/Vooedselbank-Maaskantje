<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {

    // Check auth
    if (!CheckAuth(3, $conn)) {
        // Create error cookie
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if specifics already exits
    $stmt = 'SELECT `desc` FROM `specifics` WHERE `desc` = :description';
    $data = [':description' => $_POST['description']];

    if(CheckIfExists($stmt, $data, $conn)) {
        // Create error cookie
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $data = [
        ':id' => hexdec(uniqid()),
        ':description' => $_POST["description"]
    ];

    $query = $conn->prepare("INSERT INTO specifics (specificId, desc) VALUES (:id, :description");
    $query->execute($data);

} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Create error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>