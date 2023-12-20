<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare(
        'SELECT 
        packet.`packetId`, packet.`pickUpDate`,
        customer.`firstName`, customer.`lastName`
        FROM `packet`
        LEFT JOIN `customer` ON packet.`customerId` = customer.`customerId`
        WHERE packet.`pickUpDate` > CURRENT_DATE()'
    );
    $query->execute();

    $packets = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete packet</title>
</head>
<body>
    <form action="../../actions/delete/packet.php" method="post">
        <select name="packet">
            <?php
            foreach ($packets as $pack) {
                echo 
                "<option value='" . $pack['packetId'] . "'>"
                . $pack['name'] . " " . $pack['lastName'] . " - " . $pack['pickUpDate'] .
                "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>
</body>
</html>