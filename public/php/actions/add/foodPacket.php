<?php
include_once('../../functions.php');

$conn = ConnectDB("root", "");

try {
    // Check auth
    if (!CheckAuth(1, $conn)) {
        // Send user back to previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Insert basics
    function NextWeekDay($dayOfWeek) {
        $currentDate = new DateTime();
        $currentWeekDay = $currentDate->format('w');
        $daysUntil = ($dayOfWeek - $currentWeekDay + 7) % 7;
        $nextDay = $currentDate->modify("+$daysUntil days")->format('Y-m-d');

        return $nextDay;
    }
    $packetId = hexdec(uniqid());

    $data = [
        ':packetId' => $packetId,
        ':customerId' => $_POST['custId'],
        ':makeDate' => NextWeekDay(4),
        ':pickUpDate' => NextWeekDay(5)
    ];
    $query = $conn->prepare(
        'INSERT INTO `packet`
        (`packetId`, `customerId`, `makeDate`, `pickUpDate`)
        VALUES (:packetId, :customerId, :makeDate, :pickUpDate)'
    );
    $query->execute($data);

    // Insert items
    $ean = array();
    $stockId = array();
    $amount = array();

    foreach ($_POST as $key => $value) {
        if (strpos($key, '_item') === 0) {
            $values = explode("&", $value);
            array_push($ean, $values[0]);
            array_push($stockId, $values[1]);
        } else if (strpos($key, 'itemAmount') === 0) {
            array_push($amount, $value);
        }
    }

    foreach ($ean as $i => $eanValue) {
        $data = [
            ':packetId' => $packetId,
            ':customerId' => $_POST['custId'],
            ':stockId' => $stockId[$i],
            ':ean' => $eanValue,
            ':amount' => $amount[$i]
        ];

        $query = $conn->prepare(
            'INSERT INTO `packetStock`
            (`packetId`, `customerId`, `stockId`, `EAN`, `amount`)
            VALUES (:packetId, :customerId, :stockId, :ean, :amount)'
        );
        $query->execute($data);
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    
    // Error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);