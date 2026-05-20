<?php
require_once "include/function.php";
$user = requireLogin();

if ($user['role'] === 'admin') {
    header("Location: admin/index.php");
    exit();
}

header("Location: user/index.php");
exit();
?>
