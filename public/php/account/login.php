<?php
include_once("../functions.php");

// connect to database
$conn = ConnectDB("root", "");


header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}

$json = file_get_contents('php://input');

// Converts it into a PHP object
$input = json_decode($json);

try {

    $query = $conn->prepare("SELECT userId, email,  password FROM user WHERE email = :email");
    $query->bindParam(":email", $input->email);
    $query->execute();

    $result = $query->fetchAll();

    // check if user exits
    if (!empty($result)) {
        if (password_verify($input->password, $result[0]["password"])) {
            session_start();
            $_SESSION["login"] = $result[0]["userId"];

            echo json_encode(['success' => true]);
            // Sent the user to the home page

        } else {
            // Create error cookie (incorrect password)
            echo json_encode(['success' => false, 'message' => 'Incorrect password']);
            exit();
        }
    } else {
        // Create error cookie (incorrect email)
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit();
}
