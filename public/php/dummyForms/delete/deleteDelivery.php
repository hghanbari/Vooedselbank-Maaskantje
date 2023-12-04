<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    // This gets only the not delivered deliveries
    $query = $conn->prepare(
        'SELECT 
        delivery.`deliveryId`, delivery.`deliveryDate`,
        supplier.`companyName`
        FROM delivery
        LEFT JOIN supplier
        ON delivery.`supplierId` = supplier.`supplierId`
        WHERE delivery.`delivered` IS NULL'
    );
    $query->execute();

    $delivery = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete delivery</title>
</head>
<body>
    <form action="../../actions/delete/delivery.php" method="post">
        <select name="delivery">
            <?php
            foreach ($delivery as $del) {
                echo "<option value='" . $del['deliveryId'] . "'>" . $del['companyName'] . " - " . $del['deliveryDate'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>
</body>
</html>