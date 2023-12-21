<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$json = file_get_contents('php://input');

// Converts it into a PHP object
$input = json_decode($json);

try {
    // Check auth
    if (!CheckAuth(3, $conn)) {
        // Create error cookie
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if supplier already exits
    $stmt = 'SELECT `companyName` FROM `supplier` WHERE `companyName` = :name';
    $data = [':name' => $input->companyName];

    if(CheckIfExists($stmt, $data, $conn)) {
        // Create error cookie
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $data = [
        ':id' => GenerateUUID(),
        ':name' => $input->companyName,
        ':adres' => $input->adress,
        ':contactPerson' => $input->contactPerson,
        ':email' => $input->email,
        ':telefoon' => $input->phone
    ];

    $query = $conn->prepare("INSERT INTO supplier (supplierId, companyName, adress, contactName, email, phone) 
    VALUES (:id, :name, :adres, :contactPerson, :email, :telefoon)");
    $query->execute($data);

} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Create error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

?>