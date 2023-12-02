<?php
include_once('../functions.php');

$conn = ConnectDB('root', '');

try {
    // Get customer data
    $query = $conn->prepare(
        'SELECT
        customer.`customerId` AS custId, customer.`name`, customer.`lastName`, customer.`email`, customer.`phone`, customer.`familyMemberAmount`, customer.`youngestPerson`,
        specifics.`specificId` AS specId, specifics.`desc`
        FROM customer
        LEFT JOIN customerspecifics
        ON customer.`customerId` = customerspecifics.`customerId`
        LEFT JOIN specifics
        ON customerspecifics.`specificId` = specifics.`specificId`'
    );
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Check if the table is not empty
    if (!empty($result)) {
        $data = array();
        foreach ($result as $customer) {
            $custId = $customer['custId'];
            $specId = $customer['specId'];

            // Create array key if not exists
            if (!array_key_exists($custId, $data)) {
                // Generic data
                $data[$custId] = [
                    'customerId' => $custId,
                    'firstName' => $customer['firstName'],
                    "middleName" => $customer["middleName"],
                    'lastName' => $customer['lastName'],
                    'email' => $customer['email'],
                    'phone' => $customer['phone'],
                    'familyMemberAmount' => $customer['familyMemberAmount'],
                    'youngestPerson' => $customer['youngestPerson']
                ];
            }



            if ($specId != '') {
                if (!array_key_exists('specifics', $data[$custId])) {
                    $data[$custId]['specifics'] = array();
                }

                $specData = [
                    'specificId' => $specId,
                    'specificDesc' => $customer['desc']
                ];
                array_push($data[$custId]['specifics'], $specData);
            }
        }

        header('Content-Type: application/json');

        echo json_encode($data);
    } else {
        echo "This table is empty";
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
