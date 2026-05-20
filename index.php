<?php require_once "include/function.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetPals - Buy and Sell Pets</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#f7faf7] text-slate-900">
<?php include "include/header.php"; ?>
<main>
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 py-12 grid lg:grid-cols-[1.1fr_.9fr] gap-10 items-center">
            <div>
                <p class="text-sm font-bold text-emerald-700 mb-3">Pet buy and sell system</p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-5">Find the right pet from admin-approved listings.</h1>
                <p class="text-lg text-slate-600 mb-7">Admin adds pets for sale, manages orders and keeps listings updated. Users browse available pets and place orders from their own panel.</p>
                <div class="flex flex-wrap gap-3">
                    <a class="bg-emerald-700 text-white px-5 py-3 rounded-md font-semibold hover:bg-emerald-800" href="browse.php">Browse Pets</a>
                    <a class="bg-slate-900 text-white px-5 py-3 rounded-md font-semibold hover:bg-slate-800" href="admin/login.php">Admin Login</a>
                    <a class="border border-slate-300 px-5 py-3 rounded-md font-semibold hover:border-emerald-700" href="login.php">User Login</a>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-6">
                    <i class="fas fa-store text-3xl text-emerald-700 mb-4"></i>
                    <h2 class="text-xl font-bold mb-2">Admin Panel</h2>
                    <p class="text-slate-600">Add pets, view users and update order status.</p>
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-6">
                    <i class="fas fa-cart-shopping text-3xl text-blue-700 mb-4"></i>
                    <h2 class="text-xl font-bold mb-2">User Panel</h2>
                    <p class="text-slate-600">Browse pets, place orders and track purchases.</p>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include "include/footer.php"; ?>
</body>
</html>
