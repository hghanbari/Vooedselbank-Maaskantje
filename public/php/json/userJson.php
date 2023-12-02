<?php
include_once('../functions.php');

$conn = ConnectDB('root', '');

try {
    $query = $conn->prepare(
        'SELECT
        user.`userId`, user.`firstName`, user.`lastName`, user.`email`, user.`phone`, user.`adress`, user.`auth`
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
