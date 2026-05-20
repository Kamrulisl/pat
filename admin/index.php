<?php
require_once "../include/function.php";
$admin = requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $user_id = (int) $_POST['delete_user'];
        if ($user_id !== (int) $admin['user_id']) {
            mysqli_query($conn, "DELETE FROM Users WHERE user_id=$user_id");
        }
    }

    if (isset($_POST['order_id'], $_POST['order_status'])) {
        $order_id = (int) $_POST['order_id'];
        $status = in_array($_POST['order_status'], ['pending', 'completed', 'cancelled'], true) ? $_POST['order_status'] : 'pending';
        mysqli_query($conn, "UPDATE Orders SET order_status='$status' WHERE order_id=$order_id");
    }
}

$users = mysqli_query($conn, "SELECT * FROM Users ORDER BY created_at DESC");
$pets = getPets("1=1");
$orders = mysqli_query($conn, "SELECT Orders.*, Pets.pet_name, Users.full_name AS buyer_name FROM Orders JOIN Pets ON Pets.pet_id=Orders.pet_id JOIN Users ON Users.user_id=Orders.buyer_id ORDER BY Orders.order_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - PetPals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800">
<nav class="bg-slate-950 text-white">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a class="text-2xl font-bold" href="../dashboard.php">PetPals Admin</a>
        <div class="flex gap-4 text-sm"><a href="../dashboard.php">Dashboard</a><a href="../add-pet.php">Add Product</a><a href="../logout.php">Logout</a></div>
    </div>
</nav>
<main class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    <section>
        <h1 class="text-3xl font-bold mb-4">Admin Panel</h1>
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">Users</p><h2 class="text-3xl font-bold"><?= mysqli_num_rows($users) ?></h2></div>
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">Pets</p><h2 class="text-3xl font-bold"><?= count($pets) ?></h2></div>
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">Orders</p><h2 class="text-3xl font-bold"><?= $orders ? mysqli_num_rows($orders) : 0 ?></h2></div>
        </div>
    </section>
    <section class="bg-white border rounded-lg p-5 overflow-x-auto">
        <h2 class="text-xl font-bold mb-4">Users</h2>
        <table class="w-full text-sm">
            <thead class="bg-slate-100"><tr><th class="text-left p-3">Name</th><th class="text-left p-3">Email</th><th class="text-left p-3">Role</th><th class="text-left p-3">Action</th></tr></thead>
            <tbody><?php mysqli_data_seek($users, 0); while ($users && $user = mysqli_fetch_assoc($users)): ?><tr class="border-t"><td class="p-3"><?= h($user['full_name']) ?></td><td class="p-3"><?= h($user['email']) ?></td><td class="p-3"><?= h($user['role']) ?></td><td class="p-3"><form method="POST"><button class="text-red-600" name="delete_user" value="<?= (int) $user['user_id'] ?>" onclick="return confirm('Delete user?')">Delete</button></form></td></tr><?php endwhile; ?></tbody>
        </table>
    </section>
    <section class="bg-white border rounded-lg p-5 overflow-x-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Products / Pets</h2>
            <a class="bg-emerald-600 text-white px-4 py-2 rounded-md text-sm" href="../add-pet.php">Add Product</a>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-slate-100"><tr><th class="text-left p-3">Pet</th><th class="text-left p-3">Seller</th><th class="text-left p-3">Category</th><th class="text-left p-3">Price</th><th class="text-left p-3">Status</th></tr></thead>
            <tbody><?php foreach ($pets as $pet): ?><tr class="border-t"><td class="p-3"><?= h($pet['pet_name']) ?></td><td class="p-3"><?= h($pet['seller_name']) ?></td><td class="p-3"><?= h($pet['category_name']) ?></td><td class="p-3">$<?= h($pet['price']) ?></td><td class="p-3"><?= h($pet['status']) ?></td></tr><?php endforeach; ?></tbody>
        </table>
    </section>
    <section class="bg-white border rounded-lg p-5 overflow-x-auto">
        <h2 class="text-xl font-bold mb-4">Orders</h2>
        <table class="w-full text-sm">
            <thead class="bg-slate-100"><tr><th class="text-left p-3">Pet</th><th class="text-left p-3">Buyer</th><th class="text-left p-3">Amount</th><th class="text-left p-3">Status</th></tr></thead>
            <tbody><?php while ($orders && $order = mysqli_fetch_assoc($orders)): ?><tr class="border-t"><td class="p-3"><?= h($order['pet_name']) ?></td><td class="p-3"><?= h($order['buyer_name']) ?></td><td class="p-3">$<?= h($order['total_amount']) ?></td><td class="p-3"><form method="POST" class="flex gap-2"><input type="hidden" name="order_id" value="<?= (int) $order['order_id'] ?>"><select name="order_status" class="border rounded px-2 py-1"><option <?= $order['order_status']==='pending'?'selected':'' ?> value="pending">pending</option><option <?= $order['order_status']==='completed'?'selected':'' ?> value="completed">completed</option><option <?= $order['order_status']==='cancelled'?'selected':'' ?> value="cancelled">cancelled</option></select><button class="bg-slate-800 text-white px-3 rounded">Save</button></form></td></tr><?php endwhile; ?></tbody>
        </table>
    </section>
</main>
</body>
</html>
