<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare('SELECT `supplierId`, `companyName` FROM `supplier`');
    $query->execute();

    $supplier = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit supplier</title>
</head>
<body>
    <form action="?" method="get">
        <select name="supplier">
            <?php
            foreach ($supplier as $sup) {
                echo "<option value='" . $sup['supplierId'] . "'>" . $sup['companyName'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>

    <?php
    if (isset($_GET['supplier'])) {
        ?>
        <form action="../../actions/edit/supplier.php" method="post">
            Company name: <input type="text" name="companyName"><br>
            Adress: <input type="text" name="adress"> <br>
            Contact person name: <input type="text" name="contactName"><br>
            Email: <input type="email" name="email"><br>
            Phone: <input type="text" name="phone"><br>

            <input type="hidden" name="id" value="<?php echo $_GET['supplier'] ?>">
            <input type="submit">
        </form>
        <?php
    }
    ?>
</body>
</html>