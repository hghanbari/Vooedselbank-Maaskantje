<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");
try {
    $query = $conn->prepare("SELECT supplierId, companyName FROM supplier");
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);
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
    <form action="../../actions/add/delivery.php" method="post">
        Supplier: <select name="supplier">
            <?php 
                foreach ($result as $supplier) {
                    echo "<option value='" . $supplier['supplierId'] . "'>" . $supplier['companyName'] .  "</option>";
                }
            ?>
        </select>
        Delivery date: <input type="date" name="deliveryDate">
        Delivery time: <input type="time" name="deliveryTime">
        <input type="submit">
    </form>
</body>
</html>