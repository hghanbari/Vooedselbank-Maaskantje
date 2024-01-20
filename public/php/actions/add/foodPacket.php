<?php
session_start();
include_once('../../functions.php');

// Connect to DB
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
    // Check auth
    if (!CheckAuth(1, $conn)) {
        echo json_encode(["success" => false, "message" => "Incorrect authority"]);
        exit();
    }

    // Insert basics
    function NextWeekDay($dayOfWeek)
    {
        $currentDate = new DateTime();
        $currentWeekDay = $currentDate->format('w');
        $daysUntil = ($dayOfWeek - $currentWeekDay + 7) % 7;
        $nextDay = $currentDate->modify("+$daysUntil days")->format('Y-m-d');

        return $nextDay;
    }
    $packetId = GenerateUUID();

    $data = [
        ':packetId' => $packetId,
        ':customerId' => $input->customer,
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

    foreach($input->order as $product) {
        $values = explode("&", $product->product);
        array_push($ean, $values[0]);
        array_push($stockId, $values[1]);
    }

    foreach($ean as $i => $eanValue) {
        // Update stock
        $query = $conn->prepare('UPDATE `stock` SET `inUseAmount` = `inUseAmount` + :amount WHERE `stockId` = :id');
        $query->bindParam(':amount', $input->order[$i]->amount);
        $query->bindParam(':id', $stockId[$i]);
        $query->execute();
        
        // Update packet
        $data = [
            ':packetId' => $packetId,
            ':customerId' => $input->customer,
            ':stockId' => $stockId[$i],
            ':ean' => $eanValue,
            ':amount' => $input->order[$i]->amount
        ];
    
        $query = $conn->prepare(
            'INSERT INTO `packetstock`
            (`packetId`, `customerId`, `stockId`, `EAN`, `amount`)
            VALUES (:packetId, :customerId, :stockId, :ean, :amount)'
        );
        $query->execute($data);
    }


    // // Insert items
    // $ean = array();
    // $stockId = array();
    // $amount = array();

    // foreach ($_POST as $key => $value) {
    //     if (strpos($key, '_item') === 0) {
    //         $values = explode("&", $value);
    //         array_push($ean, $values[0]);
    //         array_push($stockId, $values[1]);
    //     } else if (strpos($key, 'itemAmount') === 0) {
    //         array_push($amount, $value);
    //     }
    // }

    // foreach ($ean as $i => $eanValue) {
    //     // Update stock
    //     $query = $conn->prepare('UPDATE `stock` SET `inUseAmount` = `inUseAmount` + :amount WHERE `stockId` = :id');
    //     $query->bindParam(':amount', $amount[$i]);
    //     $query->bindParam(':id', $stockId[$i]);
    //     $query->execute();

    //     // Update packet
    //     $data = [
    //         ':packetId' => $packetId,
    //         ':customerId' => $_POST['custId'],
    //         ':stockId' => $stockId[$i],
    //         ':ean' => $eanValue,
    //         ':amount' => $amount[$i]
    //     ];

    //     $query = $conn->prepare(
    //         'INSERT INTO `packetStock`
    //         (`packetId`, `customerId`, `stockId`, `EAN`, `amount`)
    //         VALUES (:packetId, :customerId, :stockId, :ean, :amount)'
    //     );
    //     $query->execute($data);
    // }
    echo json_encode(["success" => true, "message" => "Packet has been added successfully"]);
} catch (PDOException $e) {

    // Error cookie
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit();
}
