<?php 
include_once("../functions.php");

// connect to database
$conn = ConnectDB("root", "");

try {
    // query database
    $query = $conn->prepare("SELECT userId, email, pass FROM user WHERE email = :email");
    $query->bindParam(":email", $_POST["email"]);
    $query->execute();
    
    $result = $query->fetchAll();
    
    // check if user exits
    if (!empty($result)) {
        // check if the password is correct
        if(password_verify($_POST["password"], $result[0]["pass"])) {
            session_start();
            $_SESSION["login"] = $result[0]["userId"];

            // Sent the user to the home page

        } else {
            // Create error cookie (incorrect password)

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    } else {
        // Create error cookie (incorrect email)

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();

    // Create error cookie
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

?>

