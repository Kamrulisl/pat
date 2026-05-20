<?php
require_once "include/function.php";
$panelContext = 'user';
$user = requireLogin();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = md5($_POST['current_password'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $user_id = (int) $user['user_id'];
    $result = mysqli_query($conn, "SELECT user_id FROM Users WHERE user_id=$user_id AND password_hash='$current_password' LIMIT 1");

    if ($new_password !== $confirm_password) {
        $message = "New passwords do not match.";
    } elseif (!$result || mysqli_num_rows($result) !== 1) {
        $message = "Current password is incorrect.";
    } elseif (changePassword($user_id, $new_password)) {
        $message = "Password changed successfully.";
    } else {
        $message = "Password update failed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Change Password - PetPals</title><script src="https://cdn.tailwindcss.com"></script><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"></head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[240px_1fr] gap-6">
<?php include "include/aside.php"; ?>
<section class="max-w-xl bg-white border rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6">Change Password</h1>
    <?php if ($message): ?><div class="bg-blue-50 text-blue-700 border border-blue-200 rounded-md px-4 py-3 mb-5"><?= h($message) ?></div><?php endif; ?>
    <form method="POST" class="space-y-5">
        <input class="w-full border rounded-md px-4 py-3" name="current_password" type="password" placeholder="Current password" required>
        <input class="w-full border rounded-md px-4 py-3" name="new_password" type="password" placeholder="New password" required>
        <input class="w-full border rounded-md px-4 py-3" name="confirm_password" type="password" placeholder="Confirm new password" required>
        <button class="w-full bg-blue-600 text-white font-bold py-3 rounded-md">Change Password</button>
    </form>
</section>
</main>
<?php include "include/footer.php"; ?>
</body></html>
