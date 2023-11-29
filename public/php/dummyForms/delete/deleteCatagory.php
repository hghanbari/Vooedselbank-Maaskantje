<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare('SELECT `catagoryId`, `desc` FROM `catagory`');
    $query->execute();

    $catagories = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error!: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete catagory</title>
</head>
<body>
    <form action="../../actions/delete/catagory.php" method="post">
        <select name="catagory">
            <?php
            foreach ($catagories as $cat) {
                echo "<option value='" . $cat['catagoryId'] . "'>" . $cat['desc'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>
</body>
</html>