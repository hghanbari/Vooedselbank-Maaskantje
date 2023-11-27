<?php
$_SESSION['login'] = false;

header('Location: ' . $_SERVER['HTTP_REFERER']);