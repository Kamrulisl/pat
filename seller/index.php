<?php
require_once "../include/function.php";
$seller = currentUser();

if (!$seller || $seller['role'] !== 'seller') {
    header("Location: ../login.php");
    exit();
}

$seller_id = (int) $seller['user_id'];
$pets = getPets("Pets.seller_id=$seller_id");
$orders = mysqli_query($conn, "SELECT Orders.*, Pets.pet_name, Users.full_name AS buyer_name
    FROM Orders
    JOIN Pets ON Pets.pet_id=Orders.pet_id
    JOIN Users ON Users.user_id=Orders.buyer_id
    WHERE Pets.seller_id=$seller_id
    ORDER BY Orders.order_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel - PetPals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800">
<nav class="bg-slate-950 text-white">
    <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
        <a class="text-2xl font-bold" href="../dashboard.php">PetPals Seller</a>
        <div class="flex gap-4 text-sm">
            <a href="../dashboard.php">Dashboard</a>
            <a href="../add-pet.php">Add Product</a>
            <a href="../my-pets.php">My Products</a>
            <a href="../orders.php">Orders</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>
</nav>
<main class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    <section>
        <h1 class="text-3xl font-bold mb-2">Seller Panel</h1>
        <p class="text-slate-500 mb-6">Add products/pets, check listings and manage buyer orders.</p>
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">My Products</p><h2 class="text-3xl font-bold"><?= count($pets) ?></h2></div>
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">Orders</p><h2 class="text-3xl font-bold"><?= $orders ? mysqli_num_rows($orders) : 0 ?></h2></div>
            <div class="bg-white border rounded-lg p-5"><p class="text-slate-500">Panel</p><h2 class="text-2xl font-bold">Seller</h2></div>
        </div>
    </section>
    <section class="bg-white border rounded-lg p-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <h2 class="text-xl font-bold">My Products / Pets</h2>
            <a class="bg-emerald-600 text-white px-4 py-2 rounded-md text-sm" href="../add-pet.php">Add Product</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-100"><tr><th class="text-left p-3">Name</th><th class="text-left p-3">Category</th><th class="text-left p-3">Price</th><th class="text-left p-3">Status</th></tr></thead>
                <tbody>
                <?php foreach ($pets as $pet): ?>
                    <tr class="border-t"><td class="p-3"><?= h($pet['pet_name']) ?></td><td class="p-3"><?= h($pet['category_name']) ?></td><td class="p-3">$<?= h($pet['price']) ?></td><td class="p-3"><?= h($pet['status']) ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>
</html>
