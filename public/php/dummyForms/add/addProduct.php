<?php
include_once("../../functions.php");

try {
    $conn = ConnectDB("root", "");

    $query = $conn->prepare(
        'SELECT catagory.`catagoryId`, catagory.`desc`, "catagory" AS source FROM `catagory`
        UNION ALL
        SELECT specifics.`specificId`, specifics.`desc`, "specifics" AS source FROM `specifics`'
    );
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
    <title>Add product</title>
</head>
<body>
    <form action="../../actions/add/product.php" method="post">
        EAN: <input type="text" name="EAN" required><br>
        Name: <input type="text" name="name"><br>
        Catagory: 
        <select name="catagory">
            <?php
            foreach ($result as $catagory) {
                if ($catagory['source'] == 'catagory') {
                    echo "<option value='" . $catagory['catagoryId'] . "'>" . $catagory['desc'] .  "</option>";
                }
            }
            ?>
        </select><br>

        Recommended age for consumer: <input type="number" min="0" name="age"><br>
        
        Product specifics: 
        <select name="specifics[]" multiple>
            <option value="nothing">None</option>
            <?php
            foreach ($result as $specific) {
                if ($specific['source'] == 'specifics') {
                    echo "<option value='" . $specific['catagoryId'] . "'>" . $specific['desc'] . "</option>>";
                }
            }
            ?>
        </select>

        <input type="submit">
    </form>
</body>
</html>