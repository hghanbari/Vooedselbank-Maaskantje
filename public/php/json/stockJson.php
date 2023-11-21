<?php
include_once('../functions.php');

$conn = ConnectDB('root', '');

try {
    // Get data
    $query = $conn->prepare(
        'SELECT
        stock.`stockId`, stock.`amount`, stock.`inUseAmount`, stock.`bestByDate`,
        products.`EAN`, products.`productAge`, products.`name`,
        catagory.`catagoryId`, catagory.`desc`,
        delivery.`deliveryId`, delivery.`deliveryDate`, delivery.`deliveryTime`
        FROM `stock`
        LEFT JOIN `products`
        ON stock.`EAN` = products.`EAN`
        LEFT JOIN `catagory`
        ON products.`catagoryId` = catagory.`catagoryId`
        LEFT JOIN `delivery`
        ON stock.`deliveryId` = delivery.`deliveryId`'
    );
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Put data in array
    $data = array();
    foreach ($result as $stock) {
        $stockId = $stock['stockId'];

        if (!array_key_exists($stockId, $data)) {
            $data[$stockId] = [
                'stockId' => $stockId,
                'amount' => $stock['amount'],
                'inUseAmount' => $stock['inUseAmount'],
                'bestByDate' => $stock['bestByDate'],

                'productInfo' => [
                    'ean' => $stock['EAN'],
                    'productAge' => $stock['productAge'],
                    'name' => $stock['name'],
                    'catagoryId' => $stock['catagoryId'],
                    'catagoryDesc' => $stock['desc'],
                ],

                'deliveryInfo' => [
                    'deliveryId' => $stock['deliveryId'],
                    'dilveryDate' => $stock['deliveryDate'],
                    'deliveryTime' => $stock['deliveryTime']
                ]
            ];
        }
    }

    header('Content-Type: application/json');

    echo json_encode($data);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}