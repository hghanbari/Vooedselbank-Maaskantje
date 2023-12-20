<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    // Get all packets
    $query = $conn->prepare(
        'SELECT
        packet.`packetId`, packet.`customerId`, packet.`pickUpDate`,
        customer.`firstName`, customer.`middleName`, customer.`lastName`
        FROM `packet`
        LEFT JOIN `customer` ON packet.`customerId` = customer.`customerId`
        WHERE packet.`pickUpDate` >= CURRENT_DATE()'
    );
    $query->execute();

    $packet = $query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['packet'])) {
        // Get packet items
        $query = $conn->prepare('SELECT `customerId`, `stockId`, `amount` FROM `packetstock` WHERE `packetId` = :id');
        $query->bindParam(':id', $_GET['packet']);
        $query->execute();
        $stocks = $query->fetchAll(PDO::FETCH_ASSOC);

        // Get stock items
        $query = $conn->prepare(
            'SELECT 
            stock.`stockId`, stock.`EAN`, stock.`amount` - stock.`inUseAmount` AS trueAmount,
            products.`name`
            FROM `stock`
            LEFT JOIN `products` ON stock.`EAN` = products.`EAN`'
        );
        $query->execute();
        $products = $query->fetchALL(PDO::FETCH_ASSOC);
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
    <title>Edit packet</title>
</head>
<body>
    <form action="?" method="get">
        <select name="packet">
            <?php
            foreach ($packet as $pack) {
                echo "<option value='" . $pack['packetId'] . "'>" . $pack['firstName'] . " " . $pack['middleName'] . " " . $pack['lastName'] . " - " . $pack['pickUpDate'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>

    <?php
    if (isset($_GET['packet'])) {
        ?>
        <p>Editing this packet resets everything that is not in the edited version. Please make sure that everything is reentered in the form</p>
        <form action="../../actions/edit/packet.php" method="post">
            <?php
            foreach ($stocks as $i=>$stock) {
                echo "<select name='_item$i'>";

                foreach ($products as $prod) {
                    $selected = $stock['stockId'] == $prod['stockId'] ? 'selected' : '';

                    echo 
                        "<option value='" . $prod['stockId'] . "&" . $prod['EAN'] ."' $selected>"
                        . $prod['name'] . " - " . $prod['trueAmount'] .
                        "</option>";
                }

                echo "</select>";

                echo "<input type='number' name='itemAmount$i' min='1'>";
            }
            ?>

            <input type="hidden" name="customer" value="<?php echo $stocks[0]['customerId'] ?>">
            <input type="hidden" name="packet" value="<?php echo $_GET['packet'] ?>">
            <input type="submit">
        </form>
        <?php
    }
    ?>
</body>
</html>