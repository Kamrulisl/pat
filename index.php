<?php require_once "include/function.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetPals - Pet Selling Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main>
    <section class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-5">Find pets, list pets, and manage orders in one place.</h1>
                <p class="text-lg text-slate-600 mb-7">PetPals has two panels: admin works as the seller and users work as buyers.</p>
                <div class="flex flex-wrap gap-3">
                    <a class="bg-blue-600 text-white px-5 py-3 rounded-md font-semibold hover:bg-blue-700" href="browse.php">Browse Pets</a>
                    <a class="bg-emerald-600 text-white px-5 py-3 rounded-md font-semibold hover:bg-emerald-700" href="register.php">Create Account</a>
                </div>
            </div>
            <div class="bg-slate-900 text-white rounded-lg p-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/10 rounded-lg p-5"><i class="fas fa-user text-2xl mb-4"></i><h3 class="font-bold">User / Buyer</h3><p class="text-sm text-slate-300">Browse and order available pets.</p></div>
                    <div class="bg-white/10 rounded-lg p-5"><i class="fas fa-store text-2xl mb-4"></i><h3 class="font-bold">Admin / Seller</h3><p class="text-sm text-slate-300">Add pets and track orders.</p></div>
                    <div class="bg-white/10 rounded-lg p-5"><i class="fas fa-shield-halved text-2xl mb-4"></i><h3 class="font-bold">Admin</h3><p class="text-sm text-slate-300">Manage users, listings and sales.</p></div>
                    <div class="bg-white/10 rounded-lg p-5"><i class="fas fa-database text-2xl mb-4"></i><h3 class="font-bold">MySQL</h3><p class="text-sm text-slate-300">Ready SQL schema with seed data.</p></div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include "include/footer.php"; ?>
</body>
</html>
