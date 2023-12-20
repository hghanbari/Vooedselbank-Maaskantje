<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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