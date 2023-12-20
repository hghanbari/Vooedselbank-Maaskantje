<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    $query = $conn->prepare("SELECT `userId`, `firstName`, `middleName`, `lastName` FROM `user`");
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
    <title>Delete user</title>
</head>
<body>
    <form action="../../actions/delete/user.php" method="post">
        User: <select name="user">
            <?php 
                foreach ($users as $user) {
                    echo '<option value="' . $user["userId"] . '">' . $user["firstName"] . ' ' . $user['middleName'] .  ' ' . $user["lastName"] . '</option>';
                } 
            ?>
        </select>
        Password: <input type="password" name="password">
        <input type="submit">
    </form>
</body>
</html>