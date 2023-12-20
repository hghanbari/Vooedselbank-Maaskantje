<?php
// Als je hier bent het catagory niet update, 
// het komt omdat de database NULL niet exepteert wanneer je 'none' kiest.
// Dit kan je fixen door de default van 'catagoryId' op NULL te zetten

include_once('../../functions.php');

$conn = ConnectDB('root', '');

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    if (!CheckAuth(2, $conn)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check what changed
    // Get default data
    $query = $conn->prepare('SELECT `catagoryId`, `productAge`, `name` FROM `products` WHERE `EAN` = :ean');
    $query->bindParam(':ean', $_POST['ean']);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        ':ean' => $_POST['ean'],
        ':catagory' => $result[0]['catagoryId'],
        ':age' => $result[0]['productAge'],
        ':name' => $result[0]['name']
    ];

    // Update data
    foreach ($_POST as $key=>$item) {
        if ($key == 'catagory' && $item == 'none') {
            $data[":$key"] = null;
        } else if ($key == 'catagory' && $item == 'same') {
            $data[":catagory"] = $data[":catagory"];
        } else if ($item != '' && $key != 'specifics[]') {
            $data[":$key"] = $item;
        }

        // Update specifics
        if ($key == 'specifics' && !in_array('same', $_POST['specifics'])) {
            $conn->prepare(
                'DELETE FROM `specificsforproducts` WHERE `ean` = :ean'
            )->execute([':ean' => $data[':ean']]);

            if (!in_array('none', $_POST['specifics'])) {
                foreach ($_POST['specifics'] as $spec) {
                    $query = $conn->prepare(
                        'INSERT INTO `specificsforproducts` 
                        (`specificId`, `EAN`) VALUES (:id, :ean)'
                    );
                    $query->bindParam(':id', $spec);
                    $query->bindParam(':ean', $data[':ean']);
                    $query->execute();
                }
            }
        }
    }

    // Specifics has been updated so it can be deleted to circumvent errors
    unset($data[':specifics']);

    
print_r($data);

    // Insert data
    $query = $conn->prepare('UPDATE `products` SET `catagoryId` = :catagory, `productAge` = :age, `name` = :name WHERE `EAN` = :ean');
    $query->execute($data);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

//header('Location: ' . $_SERVER['HTTP_REFERER']);