<?php
include_once('./lib/diag.php');
include_once('../functions.php');

// Get data
$conn = ConnectDB('root', '');
try {
    // Get all catagories
    $query = $conn->prepare('SELECT `catagoryId`, `desc` FROM `catagory`');
    $query->execute();
    $catagory = $query->fetchAll(PDO::FETCH_ASSOC);

    // Get all products
    $query = $conn->prepare('SELECT `EAN`, `catagoryId`, `name` FROM `products`');
    $query->execute();
    $products = $query->fetchAll(PDO::FETCH_ASSOC);

    // Get food packets from this month
    $query = $conn->prepare(
        'SELECT packetstock.`EAN`, packetstock.`amount`
        FROM `packetstock`
        LEFT JOIN `packet` ON packetstock.`packetId` = packet.`packetId`
        WHERE YEAR(packet.`pickUpDate`) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
        AND MONTH(packet.`pickUpDate`) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'
    );
    $query->execute();
    $packetStock = $query->fetchAll(PDO::FETCH_ASSOC);

    $productData = [];
    foreach ($packetStock as $stock) {
        if (!isset($productData[$stock['EAN']])) {
            $productData[$stock['EAN']] = 0;
        }

        $productData[$stock['EAN']] += $stock['amount'];
    }

    // Get suppliers and deliveries
    $query = $conn->prepare(
        'SELECT stock.`amount`, products.`EAN`, products.`name` AS `productName`, delivery.`supplierId`
        FROM `stock`
        LEFT JOIN `products` ON stock.`EAN` = products.`EAN`
        LEFT JOIN `delivery` ON stock.`deliveryId` = delivery.`deliveryId`
        WHERE YEAR(delivery.`deliveryDate`) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
        AND MONTH(delivery.`deliveryDate`) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'
    );
    $query->execute();
    $dels = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $conn->prepare('SELECT `supplierId`, `companyName` FROM `supplier`');
    $query->execute();
    $suppliers = $query->fetchAll(PDO::FETCH_ASSOC);

    // Put the correct delivery with supplier
    $deliveries = [];
    foreach ($suppliers as $supp) {
        if (!isset($deliveries[$supp['supplierId']])) {
            $deliveries[$supp['supplierId']] = ['companyName' => $supp['companyName']];

            foreach ($dels as $del) {
                if ($del['supplierId'] == $supp['supplierId']) {
                    if (!isset($deliveries[$supp['supplierId']]['items'])) {
                        $deliveries[$supp['supplierId']]['items'] = [];
                    }

                    array_push($deliveries[$supp['supplierId']]['items'], $del);
                }
            }
        }
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

// Add to FPDF
function utf8($string) {
    return iconv('UTF-8', 'windows-1252', $string);
}

class PDF extends PDF_Diag {
    function Header() {
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 16);

        // Future Hero, please make this local path
        $this->Image('c:\wamp64\www\Vooedselbank-Maaskantje\src\images\logo-sidebar.jpg', 10, 15, 50);

        $this->Cell(30);
        $this->Cell(0, 10, 'Maand raport Voedselbank Maaskantje (' . date('m-Y') . ')', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetFont('Arial', 'I', 4);
        $this->Cell(
            0, 2, 
            utf8('Als een categorie geen items heeft zal het niet zichtbaar zijn. Als een product niet is weg gegeven zal het niet zichtbaar zijn'),
            0, 1, 'L'
        );

        $this->Cell(0, 2, $this->PageNo(), 0, 0, 'R');
    }

    function List($title, $items) {
        $this->SetFont('Arial', 'BUI', 8);
        $this->Cell(100, 5, $title, 0, 1);

        $this->SetFont('Arial', 'I', 8);
        foreach ($items as $key=>$item) {
            $this->ShiftRight(9);
            $this->Cell(0, 4, utf8('• ') . $key, 0, 1);
        }
    }

    function ShiftRight($amount) {
        $this->SetX($this->GetX() + $amount);
    }
};

$pdf = new PDF();

$pdf->AddPage();

$pdf->SetTitle('Maand raport Voedselbank Maaskantje (' . date('m-Y') . ')');

// Categories
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, utf8('Voedsel categorieën en producten die daar onder vallen'), 0, 1);
foreach ($catagory as $cat) {
    $list = [];
    foreach ($products as $prod) {
        if ($cat['catagoryId'] == $prod['catagoryId']) {
            $key = $prod['EAN'] . ' - ' . $prod['name'];
            $list[$key] = isset($productData[$prod['EAN']]) ? $productData[$prod['EAN']] : 0;
        }
    }

    if (!empty($list)) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->ShiftRight(5);
        $pdf->Cell(0, 5, $cat['desc'], 0, 1);

        $pdf->ShiftRight(7);
        $pdf->List('Alle producten', $list);
        $pdf->Ln(4);

        foreach ($list as $key=>$item) {
            if ($item == 0) {
                unset($list[$key]);
            }
        }

        if (!empty($list)) {
            $pdf->SetFont('Arial', 'BUI', 8);
            $pdf->ShiftRight(7);
            $pdf->Cell(0, 4, 'Producten weg gegeven', 0, 1);
            $valX = $pdf->GetX();
            $valY = $pdf->GetY();
            $pdf->ShiftRight(9);
            $pdf->BarDiagram(190, 35, $list, '%l - %v', array(255, 175, 100));
            $pdf->SetXY($valX, $valY + 45);
        }
    }
}

$pdf->Ln(8);

// Supplier
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, utf8("Leveranciers en leveringen"), 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->ShiftRight(5);
$pdf->Cell(0, 5, utf8("Leveranciers met geleverde producten"), 0, 1);

$empty = [];
foreach ($deliveries as $del) {
    $anyDelivered = false;

    if (!empty($del)) {
        $anyDelivered = true;

        if (!empty($del['items'])) {
            $pdf->SetFont('Arial', 'BUI', 8);
            $pdf->ShiftRight(7);
            $pdf->Cell(0, 4, utf8($del['companyName']), 0, 1);

            foreach ($del['items'] as $item) {
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->ShiftRight(9);
                $pdf->Cell(0, 4, utf8('• ' . $item['EAN'] . ' - ' . $item['productName'] . ' - aantal: ' . $item['amount']), 0, 1);
            }
        } else {
            array_push($empty, $del['companyName']);
        }
    }

    if (!$anyDelivered) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->ShiftRight(7);
        $pdf->Cell(0, 4, utf8("Er zijn geen leveringen geweest deze maand"), 0, 1);
    }
}

$pdf->ln(2);

if (!empty($empty)) {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->ShiftRight(5);
    $pdf->Cell(0, 5, utf8("Leveranciers zonder geleverde producten"), 0, 1);

    foreach ($empty as $emp) {
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->ShiftRight(7);
        $pdf->Cell(0, 4, utf8('• ' . $emp), 0, 1);
    }
}

$pdf->Output();