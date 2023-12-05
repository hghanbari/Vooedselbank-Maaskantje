<?php
include_once('../../functions.php');

$conn = ConnectDB("root", "");

try {
    $query = $conn->prepare('SELECT * FROM `specifics`');
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add customer</title>
</head>
<body>
    <form action="../../actions/add/customer.php" method="post">
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
            foreach ($result as $specific) {
                echo "<option value='" . $specific['specificId'] . "'>" . $specific['desc'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>
</body>
</html>