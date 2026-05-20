<?php
session_start();
unset($_SESSION['user_id'], $_SESSION['email']);
header("Location: index.php");
exit();
?>
