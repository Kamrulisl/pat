<?php
require_once "include/function.php";
if (currentAdmin()) {
    header("Location: admin/index.php");
    exit();
}

$user = requireLogin();
header("Location: user/index.php");
exit();
?>
