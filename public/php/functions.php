<?php
// Connect to db function
function ConnectDB($user, $pass) {
    $name = 'voedselbank_maaskantje';
    try {
        // The host is currently localhost
        // This is because the current user in the DB does't have enough privillige to make a new table and stuff
        // So we will use localhost untill this is fixed
        // (Same with $name)
        $conn = new PDO('mysql:host=localhost;dbname=' . $name, $user, $pass);

        return $conn;
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage();
    }
}