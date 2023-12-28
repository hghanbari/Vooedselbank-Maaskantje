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
    $query = $conn->prepare("SELECT `userId`, `firstName`, `lastName`, `email`, `pass`, `phone`, `address`, `auth` FROM `user` WHERE `userId` = :userId");
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
        $address = $_POST["address"];
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
        if ($_POST["address"] == "") {
            $address = $user[0]["address"];
        }
        if ($_POST["auth"] == "") {
            $auth = $user[0]["auth"];
        }

        $query = $conn->prepare("UPDATE user 
        SET `firstName` = :firstName, `middleName` = :middleName, lastName = :lastName, email = :email, pass = :password, phone = :phone, address = :address, auth = :auth 
        WHERE userId = :id
        ");
        $query->bindParam(":firstName", $firstName);
        $query->bindParam(':middleName', $middleName);
        $query->bindParam(":lastName", $lastName);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);
        $query->bindParam(":phone", $phone);
        $query->bindParam(":address", $address);
        $query->bindParam(":auth", $auth);
        $query->bindParam(":id", $_POST["id"]);
        $query->execute();
    } else {
        echo json_encode(["success" => true, "message" => "User has been added successfully"]);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
