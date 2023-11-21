<?php 
include_once("../functions.php");

$conn = ConnectDB("root", "");

try {

    $query = $conn->prepare("SELECT deliveryId, supplierId, deliveryDate, deliveryTime, delivered FROM delivery");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($result)) {
        $data = [];
        foreach ($result as $delivery) {
            $data[$delivery["deliveryId"]] = [
                'deliveryId' => $delivery["deliveryId"],
                'supplierId' => $delivery["supplierId"],
                'deliveryDate' => $delivery["deliveryDate"],
                'deliveryTime' => $delivery["deliveryTime"],
                'delivered' => $delivery["delivered"]
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

?>