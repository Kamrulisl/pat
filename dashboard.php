<?php
require_once "include/function.php";
$user = requireLogin();
$user_id = (int) $user['user_id'];
$pets = getPets("Pets.status='available'");
$myOrders = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Orders WHERE buyer_id=$user_id");
$myPets = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Pets WHERE seller_id=$user_id");
$ordersCount = $myOrders ? mysqli_fetch_assoc($myOrders)['total'] : 0;
$petsCount = $myPets ? mysqli_fetch_assoc($myPets)['total'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PetPals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[240px_1fr] gap-6">
    <?php include "include/aside.php"; ?>
    <section>
        <h1 class="text-3xl font-bold mb-2">Welcome, <?= h($user['full_name'] ?: $user['username']) ?></h1>
        <p class="text-slate-500 mb-6">Role: <?= h(ucfirst($user['role'])) ?></p>
        <div class="grid md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">Available Pets</p><h2 class="text-3xl font-bold"><?= count($pets) ?></h2></div>
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">My Orders</p><h2 class="text-3xl font-bold"><?= h($ordersCount) ?></h2></div>
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500"><?= $user['role'] === 'admin' ? 'Admin Products' : 'My Purchases' ?></p><h2 class="text-3xl font-bold"><?= h($user['role'] === 'admin' ? $petsCount : $ordersCount) ?></h2></div>
        </div>
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
            <div class="flex flex-wrap gap-3">
                <a class="bg-blue-600 text-white px-4 py-2 rounded-md" href="browse.php">Browse Pets</a>
                <?php if ($user['role'] === 'admin'): ?>
                    <a class="bg-slate-800 text-white px-4 py-2 rounded-md" href="admin/index.php">Admin Panel</a>
                    <a class="bg-emerald-600 text-white px-4 py-2 rounded-md" href="add-pet.php">Add Product</a>
                    <a class="border px-4 py-2 rounded-md" href="my-pets.php">Admin Products</a>
                <?php endif; ?>
                <a class="border px-4 py-2 rounded-md" href="orders.php">Orders</a>
            </div>
        </div>
    </section>
</main>
<?php include "include/footer.php"; ?>
</body>
</html>
