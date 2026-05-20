<?php
require_once "include/function.php";
$user = requireLogin('seller');
$seller_id = (int) $user['user_id'];
$pets = getPets("Pets.seller_id=$seller_id");
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>My Pets - PetPals</title><script src="https://cdn.tailwindcss.com"></script><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"></head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[240px_1fr] gap-6">
<?php include "include/aside.php"; ?>
<section>
    <div class="flex justify-between items-center mb-6"><h1 class="text-3xl font-bold">My Pets</h1><a class="bg-emerald-600 text-white px-4 py-2 rounded-md" href="add-pet.php">Add Pet</a></div>
    <div class="bg-white border rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-100"><tr><th class="text-left p-3">Pet</th><th class="text-left p-3">Category</th><th class="text-left p-3">Price</th><th class="text-left p-3">Status</th></tr></thead>
            <tbody><?php foreach ($pets as $pet): ?><tr class="border-t"><td class="p-3"><?= h($pet['pet_name']) ?></td><td class="p-3"><?= h($pet['category_name']) ?></td><td class="p-3">$<?= h($pet['price']) ?></td><td class="p-3"><?= h($pet['status']) ?></td></tr><?php endforeach; ?></tbody>
        </table>
    </div>
</section>
</main>
<?php include "include/footer.php"; ?>
</body></html>
