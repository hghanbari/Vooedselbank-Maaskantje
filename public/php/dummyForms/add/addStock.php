<?php
include_once("../../functions.php");

$conn = ConnectDB("root", "");
try {
    $query = $conn->prepare('SELECT EAN, name FROM products');
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $query2 = $conn->prepare(
        'SELECT supplier.companyName, delivery.deliveryDate, delivery.deliveryId FROM delivery 
        INNER JOIN supplier 
        ON delivery.supplierId = supplier.supplierID'
    );
    $query2->execute();
    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="../../actions/add/stock.php" method="post">
    Product: <select name="product">
        <?php
            foreach ($result as $product) {
                echo "<option value='" . $product['EAN'] . "'>" . $product['name'] .  "</option>";
            }
        ?>
    </select>
    Delivery: <select name="delivery">
        <?php 
            foreach ($result2 as $delivery) {
                echo "<option value='" . $delivery['deliveryId'] . "'>" . $delivery['companyName'] . " " . $delivery['deliveryDate'] .  "</option>";
            }
        ?>
    </select>
    Amount: <input type="text" name="amount">
    Best by date: <input type="date" name="best_by_date">
    <input type="submit">
</form>
    
</body>
</html>