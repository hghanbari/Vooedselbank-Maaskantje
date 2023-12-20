<?php
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    $query = $conn->prepare('SELECT `customerId`, `firstName`, `middleName`, `lastName` FROM `customer`');
    $query->execute();
    $customers = $query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['customer'])) {
        // Get customer and specifics
        $query = $conn->prepare(
            'SELECT 
            customer.`customerId` AS custId, customer.`firstName`, customer.`middleName`, customer.`lastName`, customer.`youngestPerson`, 
            specifics.`specificId` AS specId, specifics.`desc` 
            FROM `customer`
            LEFT JOIN `customerSpecifics`
            ON customer.`customerId` = customerSpecifics.`customerId`
            LEFT JOIN `specifics`
            ON customerSpecifics.`specificId` = specifics.`specificId`
            WHERE customer.`customerId` = :id'
        );
        $query->bindParam(':id', $_GET['customer']);
        $query->execute();
        $customer = $query->fetchAll(PDO::FETCH_ASSOC);

        // Get stock and specifics
        $query = $conn->prepare(
            'SELECT
            stock.`stockId` AS stockId, stock.`amount`, stock.`inUseAmount`, stock.`bestByDate`,
            products.`EAN`, products.`productAge`, products.`name` AS prodName,
            catagory.`desc` AS catDesc,
            specifics.`specificId` AS specId, specifics.`desc` AS specDesc
            FROM `stock`
            LEFT JOIN `products`
            ON stock.`EAN` = products.`EAN`
            LEFT JOIN `catagory`
            ON products.`catagoryId` = catagory.`catagoryId`
            LEFT JOIN `specificsForProducts`
            ON products.`EAN` = specificsForProducts.`EAN`
            LEFT JOIN `specifics`
            ON specificsForProducts.`specificId` = specifics.`specificId`'
        );
        $query->execute();
        $stock = $query->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Add food packet</title>
</head>
<body>
    <?php
    if (isset($_GET['customer'])) {
    ?>
    <form action="../../actions/add/foodPacket.php" method="post">
        <!-- 
        -- There needs to be a button that adds more items 
        -- For now there will only be one
        -- Items should itterate like this: item0, item1, etc.
        -- color: red means that the item may not be compatible for customer
        -->
        <?php
        $customerFullName = $customer[0]['firstName'] . " " . $customer[0]['middleName'] . " " . $customer[0]['lastName'] . "<br>";
        echo $customerFullName;
        ?>
        <select name="_item0">
            <?php
            function isSpecMatching($customer, $stockItem) {
                foreach ($customer as $cust) {
                    if ($cust['specId'] == $stockItem['specId']) {
                        return true;
                    }
                }
                return false;
            }

            foreach ($stock as $stockItem) {
                $amount = $stockItem['amount'] - $stockItem['inUseAmount'];
                $col = isSpecMatching($customer, $stockItem) ? "style='color: red'" : '';

                echo "
                    <option value='" . $stockItem['EAN'] . "&" . $stockItem['stockId'] . "' $col>
                        " . $stockItem['prodName'] . " - " . $stockItem['catDesc'] . " - " . $amount . "
                    </option>";
            }
            ?>
        </select>
        Amount: <input type="number" name="itemAmount0" min="1">

        <br>

        <input type="hidden" name="custId" value="<?php echo $_GET['customer'] ?>">
        <input type="submit">
    </form>
    <br>
    <?php
    }
    ?>

    <form action="?" method="get">
        <select name="customer">
            <?php
            foreach ($customers as $customer) {
                echo "<option value='" . $customer['customerId'] . "'>" . $customer['firstName'] . " " . $customer['middleName'] . " " . $customer['lastName'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>
</body>
</html>