<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {

    $query = $conn->prepare("SELECT `specificId`, `desc` FROM `specifics`");
    $query->execute();
    $specifics = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete specifics</title>
</head>
<body>
    <form action="../../actions/delete/specifics.php" method="post">
        Specific: <select name="specifics">
            <?php 
                foreach($specifics as $specific) {
                    echo '<option value="' . $specific["specificId"] . '">' . $specific["desc"] . '</option>';
                }
            ?>
        </select>
        <input type="submit">
    </form>
    
</body>
</html>