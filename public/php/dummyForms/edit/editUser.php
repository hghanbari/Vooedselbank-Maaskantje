<?php
include_once('../../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare('SELECT userId, firstName, lastName FROM user');
    $query->execute();
    
    $users = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user</title>
</head>
<body>
    <form action="?" method="get">
        <select name="user">
            <?php
            foreach ($users as $user) {
                echo "<option value='" . $user['userId'] . "'>" . $user['name'] . " " . $user["lastName"] . "</option>";
            }
            ?>
        </select>
        <input type="submit">
    </form>

    <?php
    if (isset($_GET['user'])) {
        ?>
        <p>If left blank nothing changes</p>
        <form action="../../actions/edit/user.php" method="post">
            Firstname: <input type="text" name="firstName">
            <br>
            Middlename: <input type="text" name="middleName">
            <br>
            Lastname: <input type="text" name="lastName">
            <br>
            Email: <input type="text" name="email">
            <br>
            Current password: <input type="password" name="currPass">
            <br>
            New password: <input type="password" name="newPass">
            <br>
            Phone: <input type="text" name="phone">
            <br>
            Adress: <input type="text" name="adress">
            <br>
            Authentification: <input type="number" name="auth">
            <br>

            <input type="hidden" name="id" value="<?php echo $_GET['user'] ?>">
            <input type="submit">
        </form>
        <?php
    }
    ?>
</body>
</html>