<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Inloggen'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
    <form action="../../../../private/pages/account/signup.php" method="post">
        <label>
            Naam: <input type="text" name="name">
        </label>
        <label>
            Achternaam: <input type="text" name="lastname">
        </label>
        <label>
            Email: <input type="email" name="email">
        </label>
        <label>
            Telefoonnummer: <input type="text" name="phone">
        </label>
        <label>
            Adres: <input type="text" name="adres">
        </label>
        <select name="auth">
            <option value="1">Vrijwilliger</option>
            <option value="2">Magazijnmedewerker</option>
            <option value="3">Administatie</option>
        </select>

        <input type="submit" name="login">
    </form>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>