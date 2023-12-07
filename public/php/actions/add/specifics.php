<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    // Check auth
    if (!CheckAuth(2, $conn)) {
        // Create error cookie
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $data = [
        ':id' => GenerateUUID(),
        ':description' => $_POST["description"]
    ];

    $query = $conn->prepare("INSERT INTO `specifics` (`specificId`, `desc`) VALUES (:id, :description)");
    $query->execute($data);

} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Create error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>