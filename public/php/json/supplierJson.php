<?php 
include_once("../functions.php");

$conn = ConnectDB("root", "");

try {

    $query = $conn->prepare("SELECT supplierId, companyName, adress, contactName, email, phone FROM supplier");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($result)) {
        $data = [];
        foreach ($result as $supplier) {
            $data[$supplier["supplierId"]] = [
                'supplierId' => $supplier["supplierId"],
                'companyName' => $supplier["companyName"],
                'adress' => $supplier["adress"],
                'contactName' => $supplier["contactName"],
                'email' => $supplier["email"],
                'phone' => $supplier["phone"]
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