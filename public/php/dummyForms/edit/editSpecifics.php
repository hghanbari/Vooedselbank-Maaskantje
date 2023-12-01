<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare('SELECT `specificId`, `desc` FROM `specifics`');
    $query->execute();

    $specs = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit specifics</title>
</head>
<body>
    <form action="?" method="get">
        <select name="specific">
            <?php
            foreach ($specs as $spec) {
                echo "<option value='" . $spec['specificId'] . "'>" . $spec['desc'] . "</option>";
            }
            ?>
        </select>

        <input type="submit">
    </form>

    <?php
    if (isset($_GET['specific'])) {
        ?>
        <form action="../../actions/edit/specifics.php" method="post">
            Description: <input type="text" name="desc">

            <input type="hidden" name="id" value="<?php echo $_GET['specific'] ?>">
            <input type="submit">
        </form>
        <?php
    }
    ?>
</body>
</html>