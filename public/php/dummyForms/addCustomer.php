<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add customer</title>
</head>
<body>
    <form action="../actions/add/customer.php" method="post">
        name: <input type="text" name="name"><br>
        last name: <input type="text" name="lastName"><br>
        email: <input type="email" name="email"><br>
        phone number: <input type="text" name="phone"><br>
        family member amount: <input type="number" name="amount" min="1"><br>
        youngest person: <input type="date" name="youngest" max="<?php echo date("Y-m-d"); ?>"><br>

        <input type="submit">
    </form>
</body>
</html>