<?php
require_once "include/function.php";
$admin = currentAdmin();
$user = currentUser();
$panel = $_GET['panel'] ?? '';

if (!$admin && !$user) {
    header("Location: login.php");
    exit();
}

$adminContext = $panel === 'admin' || ($admin && !$user);
$userContext = $panel === 'user' || ($user && !$admin);

if ($adminContext && !$admin) {
    header("Location: admin/login.php");
    exit();
}

if ($userContext && !$user) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $adminContext) {
    $order_id = (int) $_POST['order_id'];
    $status = in_array($_POST['order_status'], ['pending', 'completed', 'cancelled'], true) ? $_POST['order_status'] : 'pending';
    mysqli_query($conn, "UPDATE Orders JOIN Pets ON Pets.pet_id=Orders.pet_id SET Orders.order_status='$status', Pets.status='" . ($status === 'completed' ? 'sold' : ($status === 'cancelled' ? 'available' : 'pending')) . "' WHERE Orders.order_id=$order_id");
}

if ($adminContext) {
    $admin_id = (int) $admin['admin_id'];
    $sql = "SELECT Orders.*, Pets.pet_name, Users.full_name AS user_name FROM Orders JOIN Pets ON Pets.pet_id=Orders.pet_id JOIN Users ON Users.user_id=Orders.user_id WHERE Pets.admin_id=$admin_id ORDER BY Orders.order_date DESC";
} else {
    $user_id = (int) $user['user_id'];
    $sql = "SELECT Orders.*, Pets.pet_name, Users.full_name AS user_name FROM Orders JOIN Pets ON Pets.pet_id=Orders.pet_id JOIN Users ON Users.user_id=Orders.user_id WHERE Orders.user_id=$user_id ORDER BY Orders.order_date DESC";
}
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Orders - PetPals</title><script src="https://cdn.tailwindcss.com"></script><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"></head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[240px_1fr] gap-6">
<?php include "include/aside.php"; ?>
<section>
    <h1 class="text-3xl font-bold mb-6">Orders</h1>
    <div class="bg-white border rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-100"><tr><th class="text-left p-3">Pet</th><th class="text-left p-3">User</th><th class="text-left p-3">Amount</th><th class="text-left p-3">Status</th><th class="text-left p-3">Date</th></tr></thead>
            <tbody>
            <?php while ($result && $row = mysqli_fetch_assoc($result)): ?>
                <tr class="border-t">
                    <td class="p-3"><?= h($row['pet_name']) ?></td><td class="p-3"><?= h($row['user_name']) ?></td><td class="p-3">$<?= h($row['total_amount']) ?></td>
                    <td class="p-3">
                        <?php if ($adminContext): ?>
                            <form method="POST" class="flex gap-2"><input type="hidden" name="order_id" value="<?= (int) $row['order_id'] ?>"><select name="order_status" class="border rounded px-2 py-1"><option <?= $row['order_status']==='pending'?'selected':'' ?> value="pending">pending</option><option <?= $row['order_status']==='completed'?'selected':'' ?> value="completed">completed</option><option <?= $row['order_status']==='cancelled'?'selected':'' ?> value="cancelled">cancelled</option></select><button class="bg-slate-800 text-white px-3 rounded">Save</button></form>
                        <?php else: ?><?= h($row['order_status']) ?><?php endif; ?>
                    </td>
                    <td class="p-3"><?= h($row['order_date']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
</main>
<?php include "include/footer.php"; ?>
</body></html>
