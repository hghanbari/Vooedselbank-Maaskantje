<?php
include_once("../../functions.php");

$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    $query = $conn->prepare("SELECT `userId`, `firstName`, `lastName`, `email`, `pass`, `phone`, `adress`, `auth` FROM `user` WHERE `userId` = :userId");
    $query->bindParam(":userId", $_POST["id"]);
    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_ASSOC);

    // Check current password
    if (password_verify($_POST["currPass"], $user[0]["pass"])) {
        $firstName = $_POST["firstName"];
        $middleName = $_POST['middleName'];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $password = password_hash($_POST["newPass"], PASSWORD_BCRYPT);
        $phone = $_POST["phone"];
        $adress = $_POST["adress"];
        $auth = $_POST["auth"];
        
        if ($_POST["firstName"] == "") {
            $firstName = $user[0]["firstName"];
        }
        if ($_POST['middleName'] == "") {
            $middleName = isset($user[0]['middleName']) ? $user[0]['middleName'] : null;
        }
        if ($_POST["lastName"] == "") {
            $lastName = $user[0]["lastName"];
        }
        if ($_POST["email"] == "") {
            $email = $user[0]["email"];
        }
        if ($_POST["newPass"] == "") {
            $password = $user[0]["pass"];
        }
        if ($_POST["phone"] == "") {
            $phone = $user[0]["phone"];
        }
        if ($_POST["adress"] == "") {
            $adress = $user[0]["adress"];
        }
        if ($_POST["auth"] == "") {
            $auth = $user[0]["auth"];
        }

        $query = $conn->prepare("UPDATE user 
        SET `firstName` = :firstName, `middleName` = :middleName, lastName = :lastName, email = :email, pass = :password, phone = :phone, adress = :adress, auth = :auth 
        WHERE userId = :id
        ");
        $query->bindParam(":firstName", $firstName);
        $query->bindParam(':middleName', $middleName);
        $query->bindParam(":lastName", $lastName);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);
        $query->bindParam(":phone", $phone);
        $query->bindParam(":adress", $adress);
        $query->bindParam(":auth", $auth);
        $query->bindParam(":id", $_POST["id"]);
        $query->execute();
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

} catch (PDOException $e) {
    echo "Error!" . $e->getMessage();
}


?>