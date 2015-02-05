<?php
session_start();
 unset($_SESSION['valid_user']);
 unset($_SESSION['db']);
session_destroy();
header('Location:index.php');
?>