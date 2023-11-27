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

    // Check if supplier already exits
    $stmt = 'SELECT `companyName` FROM `supplier` WHERE `companyName` = :name';
    $data = [':name' => $_POST['bedrijfsnaam']];

    if(CheckIfExists($stmt, $data, $conn)) {
        // Create error cookie
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $data = [
        ':id' => hexdec(uniqid()),
        ':name' => $_POST["bedrijfsnaam"],
        ':adres' => $_POST["adres"],
        ':contactPerson' => $_POST["contact_persoon"],
        ':email' => $_POST["email"],
        ':telefoon' => $_POST["telefoon"]
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