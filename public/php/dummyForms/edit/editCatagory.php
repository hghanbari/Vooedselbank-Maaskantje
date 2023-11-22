<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare('SELECT `catagoryId`, `desc` FROM `catagory`');
    $query->execute();
    
    $catagories = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit catagory</title>
</head>
<body>
    <form action="?" method="get">
        <select name="catagory">
            <?php
            foreach ($catagories as $item) {
                echo "<option value='" . $item['catagoryId'] . "'>" . $item['desc'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>

    <?php
    if (isset($_GET['catagory'])) {
        ?>
        <p>If left blank nothing changes</p>
        <form action="../../actions/edit/catagory.php" method="post">
            <input type="text" name="desc">

            <input type="hidden" name="id" value="<?php echo $_GET['catagory'] ?>">
            <input type="submit">
        </form>
        <?php
    }
    ?>
</body>
</html>