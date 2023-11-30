<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    $query = $conn->prepare("SELECT stock.stockId, products.name, stock.amount, supplier.companyName FROM stock 
    LEFT JOIN products
    ON stock.EAN = products.EAN
    LEFT JOIN supplier
    ON supplier.supplierId = stock.supplierId
    ");
    $query->execute();
    $stock = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete stock</title>
</head>
<body>
    <form action="../../actions/delete/stock.php" method="post">
        Stock: <select name="stock">
            <?php 
                foreach ($stock as $stockItem) {
                    echo '<option value="' . $stockItem["stockId"] . '">' . $stockItem["name"] . ' (' . $stockItem["amount"] . ') - ' . $stockItem["companyName"] . '</option>';
                }
            ?>
        </select>
        <input type="submit">
    </form>
</body>
</html>