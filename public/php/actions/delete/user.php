<?php 
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    // check auth
    if (!CheckAuth(3, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    // check if user exists
    $stmt = 'SELECT userId, pass FROM user WHERE userId = :userId';
    $data = [':userId' => $_POST["user"]];
    if (!CheckIfExists($stmt, $data, $conn)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    // Check password
    $password = $conn->prepare("SELECT pass FROM user WHERE userId = :userId");
    $password->bindParam(":userId", $_POST["user"]);
    $password->execute();

    if (!password_verify($_POST["password"], $password[0]["pass"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    $query = $conn->prepare("DELETE FROM user WHERE userId = :userId");
    $query->bindParam(':userId', $_POST["user"]);
    $query->execute();
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>