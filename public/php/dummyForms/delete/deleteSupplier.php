<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    $query = $conn->prepare("SELECT supplierId, companyName FROM supplier");
    $query->execute();
    $supplier = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete supplier</title>
</head>
<body>
    <form action="../../actions/delete/supplier.php" method="post">
        Supplier: <select name="supplier">
            <?php 
                foreach ($supplier as $supplierItem) {
                    echo '<option value="' . $supplierItem["supplierId"] . '">' . $supplierItem["companyName"] . '</option>';
                }
            ?>
        </select>
        <input type="submit">
    </form>
</body>
</html>