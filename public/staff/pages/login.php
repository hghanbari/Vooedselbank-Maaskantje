<?php require_once('../../../private/initialize.php'); ?>
<?php $page_title = 'Inloggen'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
    <form action="../../../private/pages/account/login.php" method="post">
        <label>
            Email: <input type="email" name="email">
        </label>
        <label>
            Wachtwoord: <input type="password" name="pass">
        </label>
        
        <input type="submit" name="login">
    </form>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>