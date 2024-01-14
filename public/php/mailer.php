<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/autoload.php";

// $mail = new PHPMailer(true);

$mail -> isSMTP();
$mail -> SMPTAuth = true;


$mail -> Host = "";
// $mail -> SMPTSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail -> Port = "";
$mail -> UserName = "";
$mail -> Password = "";
// ^ deze bestanden zouden beter in een .n bestand gaan.

$mail-> isHtml = true;