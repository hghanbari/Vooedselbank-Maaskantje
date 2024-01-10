<?php
session_start();
include_once('../functions.php');

$conn = ConnectDB('root', '');

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}

try {
    $query = $conn->prepare(
        'SELECT
        user.`userId`, user.`firstName`, user.`middleName`,user.`lastName`, user.`email`, user.`phone`, user.`address`, user.`auth`
        FROM `user`'
    );
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $data = array();

        foreach ($result as $user) {
            $data[$user['userId']] = [
                'userId' => $user['userId'],
                'firstName' => $user['firstName'],
                'middleName' => $user['middleName'],
                'lastName' => $user['lastName'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'address' => $user['address'],
                'auth' => $user['auth']
            ];
        }

        header('Content-Type: application/json');

        echo json_encode($data);
    } else {
        echo json_encode(["success" => false, "message" => "This table is empty"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
