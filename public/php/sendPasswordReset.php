<?php

$email = $_POST("email");

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s" ,time() + 60 * 30) ;

$mysqli = require __DIR__ .  "/database.php";

$sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ? 
        WHERE email = ?";

$stmt = $mysqli -> prepare($sql);

$stmt->bind_param("sss",$token_hash, $expiry, $email) ;

$stmt->execute();

if ($mysqli-> affected_rows)
{    
    $mail = require __DIR__ . "/mailer.php";

    $mail -> setFrom("noreply email here");

    $mail -> addAddress($email);

    $mail -> Subject = "Password Reset";

    // $mail -> Body = <<<End

    // Click <a href = "voorbeeldsite">Here</a> to reset your password

    // END;
    try {
        $mail->send();
    } catch (Exception $e) {
        echo "message could not be sent. Mailer error: ($mail->ErrorInfo)";
    }
}
echo "Message semt, please check your email";