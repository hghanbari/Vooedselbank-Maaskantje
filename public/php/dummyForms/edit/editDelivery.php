<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare(
        'SELECT delivery.deliveryId, supplier.companyName, delivery.deliveryDate, delivery.deliveryTime, delivery.delivered FROM delivery
        INNER JOIN supplier
        ON supplier.supplierId = delivery.supplierId
        ');
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
    <title>Edit delivery</title>
</head>
<body>
    <form action="?" method="get">
        <select name="delivery">
            <?php
            foreach ($delivery as $item) {
                echo "<option value='" . $item['deliveryId'] . "'>" . $item['companyName'] . " " . $item["deliveryDate"] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>

    <?php
    if (isset($_GET['delivery'])) {
        ?>
        <p>If left blank nothing changes</p>
        <form action="../../actions/edit/delivery.php" method="post">
            Delivery date: <input type="date" name="deliveryDate">
            Delivery Time: <input type="time" name="deliveryTime">
            Delivered: <input type="checkbox" name="delivered">

            <input type="hidden" name="id" value="<?php echo $_GET['delivery'] ?>">
            <input type="submit">
        </form>
        <?php
    }
    ?>
</body>
</html>