<?php
session_start();
include_once("../../functions.php");

// connect to database
$conn = ConnectDB("root", "");

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}

try {
    $json = file_get_contents('php://input');

    // Converts it into a PHP object
    $input = json_decode($json);

    $userId = $_SESSION["login"];
    
    // Get user info
    $query = $conn->prepare('SELECT * FROM `user` WHERE `userId` = :id');
    $query->execute([':id' => $userId]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        if (password_verify($input->password, $result[0]['password'])) {
            $data = [
                ':id' => $userId,
                ':fName' => $input->firstName,
                ':mName' => $input->middleName,
                ':lName' => $input->lastName,
                ':email' => $input->email,
                ':phone' => $input->phone,
                ':address' => $input->address
            ];

            $addNPass = "";
            if ($input->nPassword != "") {
                $data[':nPass'] = password_hash($input->nPassword, PASSWORD_BCRYPT);
                $addNPass = ", `password` = :nPass";
            }

            $conn->prepare(
                'UPDATE `user` SET
                `firstName` = :fName, `middleName` = :mName, `lastName` = :lName,
                `email` = :email, `phone` = :phone, `address` = :address' . $addNPass . '
                WHERE `userId` = :id'
            )->execute($data);

            echo json_encode(["success" => true, "message" => "Profiel informatie geupdate"]);
        } else {
            echo json_encode(["success" => false, "message" => "Incorrect wachtwoord"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
