<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare('SELECT `customerId`, `firstName`, `middleName`, `lastName` FROM `customer`');
    $query->execute();

    $customers = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete customer</title>
</head>
<body>
    <form action="../../actions/delete/customer.php" method="post">
        <select name="customer">
            <?php
            foreach ($customers as $cust) {
                echo "<option value='" . $cust['customerId'] . "'>" . $cust['firstName'] . " " . $cust['middleName'] . " " . $cust['lastName'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>
</body>
</html>