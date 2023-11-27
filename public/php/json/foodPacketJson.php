<?php 
include_once("../functions.php");

$conn = ConnectDB("root", "");


try {
    $query = $conn->prepare(
        "SELECT packet.packetId, packet.customerId, packet.makeDate, packet.pickUpDate, customer.name, customer.lastname, packetStock.stockId, packetStock.EAN, packetStock.amount, products.name AS productName FROM packet
        LEFT JOIN customer
        ON packet.customerId = customer.customerId
        LEFT JOIN packetStock
        ON packetStock.packetId = packet.packetId
        LEFT JOIN products
        ON packetStock.EAN = products.EAN
        ");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($result)) {
        $data = [];
        foreach ($result as $packet) {
            $packetId = $packet["packetId"];


            if (!array_key_exists($packetId, $data)) {
                $data[$packetId] = [
                    'packetId' => $packetId,
                    'customer' => [
                        'customerId' => $packet["customerId"],
                        'customerName' => $packet["name"],
                        'customerLastName' => $packet["lastname"]
                    ],
                    'makeDate' => $packet["makeDate"],
                    'pickUpDate' => $packet["pickUpDate"]
                ];
            }

            if ($packet["EAN"] != "") {
                if (!array_key_exists('products', $data[$packetId])) {
                    $data[$packetId]['products'] = array();
                }
                
                $productData = [
                    'EAN' => $packet["EAN"],
                    'amount' => $packet["amount"],
                    'productName' => $packet["productName"]
                ];
                array_push($data[$packetId]['products'], $productData);
            }
        } 
        header('Content-Type: application/json');

        echo json_encode($data);
    } else {
        echo "No tables in database";
    }

} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>