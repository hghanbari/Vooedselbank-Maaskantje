<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare(
        'SELECT stock.`stockId`, products.`name` FROM `stock`
        LEFT JOIN `products` ON stock.`EAN` = products.`EAN`'
    );
    $query->execute();

    $stockItems = $query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['stock'])) {
        $query = $conn->prepare('SELECT `EAN`, `name` FROM `products`');
        $query->execute();

        $products = $query->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo 'Error!: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stock</title>
</head>
<body>
    <form action="?" method="get">
        <select name="stock">
            <?php
            foreach ($stockItems as $stock) {
                echo "<option value='" . $stock['stockId'] . "'>" . $stock['stockId'] . " - " . $stock['name'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>

    <?php
    if (isset($_GET['stock'])) {
        ?>
        <form action="../../actions/edit/stock.php" method="post">
            product
            <select name="product">
                <option value="same">same</option>
                <?php
                foreach ($products as $prod) {
                    echo "<option value='" . $prod['EAN'] . "'>" . $prod['name'] . "</option>";
                }
                ?>
            </select> <br>

            Amount: <input type="number" name="amount"><br>
            In use: <input type="number" name="inUse"><br>
            Best by:<input type="date" name="bestBy"><br>

            <input type="hidden" name="stock" value="<?php echo $_GET['stock'] ?>">
            <input type="submit">
        </form>
        <?php
    }
    ?>
</body>
</html>