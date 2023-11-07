<?php
// Call this when you need to connect with a specific user
function ConnectDB($user) {
    $serverName = "localhost";
    $dbName = "voedselbank_maaskantje";
    $pass = "";

    try {
        return $conn = new PDO('mysql:host=' . $serverName . ';dbname=' . $dbName, $user, $pass);
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage();
    }
}

function ReturnError($msg, $location) {
    setcookie('err', $msg, time() + 3, '/');
    header('Location: ' . $location);
}
?>
