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
    if (!CheckAuth(3, $conn)) {
        // Return
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // get supplierId
    $query = $conn->prepare(
        "SELECT supplier.`supplierId` FROM supplier
        INNER JOIN delivery ON delivery.`supplierId` = supplier.`supplierId`
        WHERE delivery.`deliveryId` = :id
    ");

    $query->execute([':id' => $_POST['delivery']]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        ':id' => GenerateUUID(),
        ':ean' => $_POST["product"],
        ':deliveryId' => $_POST["delivery"],
        ':supplierId' => $result[0]['supplierId'],
        ':amount' => $_POST["amount"],
        ':inUse' => 0,
        ':bestByDate' => $_POST["best_by_date"]
    ];

    $query->closeCursor();
    unset($query);
    unset($result);

    $query = $conn->prepare(
        "INSERT INTO stock (stockId, EAN, deliveryId, supplierId, amount, inUseAmount, bestByDate)
        VALUES (:id, :ean, :deliveryId, :supplierId, :amount, :inUse, :bestByDate)");
    $query->execute($data);
    $query->closeCursor();
    unset($query);
    unset($data);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

?>