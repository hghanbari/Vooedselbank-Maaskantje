<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    // Check if supplier already exits
    $query = $conn->prepare("SELECT companyName FROM supplier");
    $query->execute();

    $result = $query->fetchAll();

    if(!empty($result)) {
        // Create error cookie

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $query->closeCursor();
    unset($query);
    unset($result);

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