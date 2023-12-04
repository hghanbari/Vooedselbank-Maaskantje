<?php
include_once("../../functions.php");

$conn = ConnectDB("root", "");

try {
    $query = $conn->prepare("SELECT `userId`, `firstName`, `lastName`, `email`, `pass`, `phone`, `adress`, `auth` FROM `user` WHERE `userId` = :userId");
    $query->bindParam(":userId", $_POST["id"]);
    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_ASSOC);

    // Check current password
    if (password_verify($_POST["currPass"], $user[0]["pass"])) {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $password = password_hash($_POST["newPass"], PASSWORD_BCRYPT);
        $phone = $_POST["phone"];
        $adress = $_POST["adress"];
        $auth = $_POST["auth"];

        // Check if any field is filled in
        if ($_POST["firstName"] == "" && $_POST["lastName"] == "" && $_POST["email"] == "" && $_POST["newPass"] == "" && $_POST["phone"] == "" && $_POST["adress"] == "" && $_POST["auth"] == "") {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        
        if ($_POST["firstName"] == "") {
            $firstName = $user[0]["name"];
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
        SET `firstName` = :firstName, lastName = :lastName, email = :email, pass = :password, phone = :phone, adress = :adress, auth = :auth 
        WHERE userId = :id
        ");
        $query->bindParam(":firstName", $firstName);
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