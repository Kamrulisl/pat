<?php
require_once "../include/function.php";
$user = currentUser();

if (!$user) {
    header("Location: ../login.php");
    exit();
}

$user_id = (int) $user['user_id'];
$pets = getPets("Pets.status='available'");
$orders = mysqli_query($conn, "SELECT Orders.*, Pets.pet_name
    FROM Orders
    JOIN Pets ON Pets.pet_id=Orders.pet_id
    WHERE Orders.user_id=$user_id
    ORDER BY Orders.order_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel - PetPals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800">
<nav class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
        <a class="text-2xl font-bold" href="../index.php"><span class="text-blue-600">Pet</span><span class="text-emerald-600">Pals</span></a>
        <div class="flex gap-4 text-sm font-medium">
            <a href="../browse.php?panel=user">Browse Pets</a>
            <a href="../orders.php?panel=user">Orders</a>
            <a href="../profile.php">Profile</a>
            <a href="../logout.php" class="text-red-600">Logout</a>
        </div>
    </div>
</nav>
<main class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[240px_1fr] gap-6">
    <?php include "../include/aside.php"; ?>
    <div class="space-y-8">
    <section>
        <h1 class="text-3xl font-bold mb-2">User Panel</h1>
        <p class="text-slate-500 mb-6">Browse pets and place orders.</p>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">Available Pets</p><h2 class="text-3xl font-bold"><?= count($pets) ?></h2></div>
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">My Orders</p><h2 class="text-3xl font-bold"><?= $orders ? mysqli_num_rows($orders) : 0 ?></h2></div>
        </div>
    </section>
    <section class="bg-white border rounded-lg p-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <h2 class="text-xl font-bold">My Orders</h2>
            <a class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm" href="../browse.php?panel=user">Browse Pets</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-100"><tr><th class="text-left p-3">Pet</th><th class="text-left p-3">Amount</th><th class="text-left p-3">Status</th><th class="text-left p-3">Date</th></tr></thead>
                <tbody>
                <?php while ($orders && $order = mysqli_fetch_assoc($orders)): ?>
                    <tr class="border-t"><td class="p-3"><?= h($order['pet_name']) ?></td><td class="p-3">$<?= h($order['total_amount']) ?></td><td class="p-3"><?= h($order['order_status']) ?></td><td class="p-3"><?= h($order['order_date']) ?></td></tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
    </div>
</main>
</body>
</html>
