<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare('SELECT `EAN`, `name` FROM `products`');
    $query->execute();
    $products = $query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['product'])) {
        $query = $conn->prepare('SELECT `catagoryId`, `desc` FROM `catagory`');
        $query->execute();
        $catagories = $query->fetchAll(PDO::FETCH_ASSOC);

        $query = $conn->prepare('SELECT `specificId`, `desc` FROM `specifics`');
        $query->execute();
        $specifics = $query->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit product</title>
</head>
<body>
    <form action="?" method="get">
        <select name="product">
            <?php
            foreach ($products as $product) {
                echo "<option value='" . $product['EAN'] . "'>" . $product['name'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>

    <br>

    <?php
    if (isset($_GET['product'])) {
        ?>
        <form action="../../actions/edit/product.php" method="post">
            Recommended consumer age: <input type="number" name="age">
            <br>
            Name: <input type="text" name="name">
            <br>

            Catagory:
            <select name="catagory">
                <option value='same' selected=''>Stay the same</option>
                <option value="none">none</option>
                <?php
                foreach ($catagories as $catagory) {
                    echo "<option value='" . $catagory['catagoryId'] . "'>" . $catagory['desc'] .  "</option>";
                }
                ?>
            </select><br>
            
            Specifics:
            <select name="specifics[]" multiple>
                <option value='same' selected=''>Stay the same</option>
                <option value="none">none</option>

                <?php
                foreach ($specifics as $spec) {
                    echo "<option value='" . $spec['specificId'] . "'>" . $spec['desc'] . "</option>";
                }
                ?>
            </select>

            <input type="hidden" name="ean" value="<?php echo $_GET['product'] ?>">
            <input type="submit">
        </form>
        <?php
    }
    ?>
</body>
</html>