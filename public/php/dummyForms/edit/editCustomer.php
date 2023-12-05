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
    <title>Edit customer</title>
</head>
<body>
    <form action="?" method="get">
        <select name="customer">
            <?php
            foreach ($customers as $customer) {
                echo "<option value='" . $customer['customerId'] . "'>" . $customer['firstName'] . " " . $customer['middleName'] . " " . $customer['lastName'] . "</option>";
            }
            ?>
        </select><br>
        <input type="submit">
    </form>

    <?php
    if (isset($_GET['customer'])) {
        try {
            $query = $conn->prepare('SELECT * FROM `specifics`');
            $query->execute();
        
            $specifics = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error!: " . $e->getMessage();
        }

        ?>
        <p>When left blank nothing will change</p>

        <form action="../../actions/edit/customer.php" method="post">
        name: <input type="text" name="name"><br>
        middle name: <input type="text" name="middleName"><br>
        last name: <input type="text" name="lastName"><br>
        email: <input type="email" name="email"><br>
        phone number: <input type="text" name="phone"><br>
        family member amount: <input type="number" name="amount" min="1"><br>
        youngest person: <input type="date" name="youngest" max="<?php echo date("Y-m-d"); ?>"><br>
        Specifics: 
        <select name="specifics[]" multiple>
            <option value="nothing">None</option>
            <?php
            foreach ($specifics as $specific) {
                echo "<option value='" . $specific['specificId'] . "'>" . $specific['desc'] . "</option>";
            }
            ?>
        </select>

        <input type="hidden" name="id" value="<?php echo $_GET['customer'] ?>">
        <input type="submit">
    </form>
        <?php
    }
    ?>
</body>
</html>