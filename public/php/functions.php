<?php
// Connect to db function
function ConnectDB($user, $pass)
{
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

function CheckAuth($minAuth, $conn)
{
    $query = $conn->prepare('SELECT `auth` FROM `user` WHERE `userId` = :id');
    $query->bindParam(':id', $_SESSION['login']);
    $query->execute();

    $result = $query->fetchAll();

    if ($result >= $minAuth) {
        return true;
    }

    return false;
}

function CheckIfExists($stmt, $dataset, $conn)
{
    $query = $conn->prepare($stmt);
    $query->execute($dataset);

    $result = $query->fetchAll();
    if (!empty($result)) {
        return true;
    }

    return false;
}

function GenerateUUID()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
        mt_rand(0, 0x0fff) | 0x4000,

        // 8 bits, the last two of which (positions 6 and 7 of the first byte) are 10 for "clock_seq_hi_and_reserved"
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
