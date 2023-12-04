<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare('SELECT `EAN`, `name` FROM `products`');
    $query->execute();

    $products = $query->fetchALL(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete product</title>
</head>
<body>
    <form action="../../actions/delete/product" method="post">
        <select name="product">
            <?php
            foreach ($products as $prod) {
                echo "<option value='" . $prod['EAN'] . "'>" . $prod['name'] ."</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>
</body>
</html>