<?php
include_once('../functions.php');

$conn = ConnectDB('root', '');

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    $query = $conn->prepare(
        'SELECT
        user.`userId`, user.`name`, user.`lastName`, user.`email`, user.`phone`, user.`adress`, user.`auth`
        FROM `user`'
    );
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $data = array();

        foreach ($result as $user) {
            $data[$user['userId']] = [
                'userId' => $user['userId'],
                'name' => $user['name'],
                'lastName' => $user['lastName'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'adress' => $user['adress'],
                'auth' => $user['auth']
            ];
        }

        header('Content-Type: application/json');

        echo json_encode($data);
    } else {
        echo "This table is empty";
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}