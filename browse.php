<?php
require_once "include/function.php";
$message = "";
$panel = $_GET['panel'] ?? '';
$adminContext = $panel === 'admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pet_id'])) {
    if ($adminContext) {
        $message = "Admin can browse pets, but only users can place orders.";
    } else {
    $user = requireLogin();
    $pet_id = (int) $_POST['pet_id'];
    $pet = getPetById($pet_id);

    if (!$pet || $pet['status'] !== 'available') {
        $message = "This pet is not available.";
    } else {
        $amount = (float) $pet['price'];
        mysqli_query($conn, "INSERT INTO Orders (user_id, pet_id, total_amount) VALUES ({$user['user_id']}, $pet_id, $amount)");
        mysqli_query($conn, "UPDATE Pets SET status='pending' WHERE pet_id=$pet_id");
        $message = "Order placed successfully.";
    }
    }
}

$category = isset($_GET['category']) ? (int) $_GET['category'] : 0;
$where = "Pets.status='available'";
if ($category > 0) {
    $where .= " AND Pets.category_id=$category";
}
$pets = getPets($where);
$categories = getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Pets - PetPals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold">Available Pets</h1>
            <p class="text-slate-500">Choose a category and place an order.</p>
        </div>
        <form method="GET">
            <select name="category" onchange="this.form.submit()" class="border rounded-md px-4 py-2 bg-white">
                <option value="0">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= (int) $cat['category_id'] ?>" <?= $category === (int) $cat['category_id'] ? 'selected' : '' ?>><?= h($cat['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <?php if ($message): ?><div class="bg-blue-50 text-blue-700 border border-blue-200 rounded-md px-4 py-3 mb-5"><?= h($message) ?></div><?php endif; ?>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($pets as $pet): ?>
            <article class="bg-white border rounded-lg overflow-hidden">
                <img class="w-full h-52 object-cover bg-slate-100" src="<?= $pet['pet_image'] ? 'uploads/doc/' . h($pet['pet_image']) : 'uploads/pat.jpg' ?>" alt="<?= h($pet['pet_name']) ?>">
                <div class="p-5">
                    <div class="flex justify-between gap-3 mb-2">
                        <h2 class="text-xl font-bold"><?= h($pet['pet_name']) ?></h2>
                        <span class="font-bold text-emerald-700">$<?= h($pet['price']) ?></span>
                    </div>
                    <p class="text-sm text-slate-500 mb-3"><?= h($pet['category_name']) ?> &bull; <?= h($pet['breed']) ?> &bull; <?= h($pet['age']) ?> months &bull; <?= h($pet['gender']) ?></p>
                    <p class="text-slate-600 mb-4"><?= h($pet['description']) ?></p>
                    <p class="text-sm mb-4"><strong>Added by Admin:</strong> <?= h($pet['admin_name']) ?> <?= $pet['admin_phone'] ? '(' . h($pet['admin_phone']) . ')' : '' ?></p>
                    <?php if ($adminContext): ?>
                        <div class="w-full bg-slate-100 text-slate-600 text-center py-2 rounded-md">Admin view only</div>
                    <?php else: ?>
                        <form method="POST">
                            <input type="hidden" name="pet_id" value="<?= (int) $pet['pet_id'] ?>">
                            <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Order This Pet</button>
                        </form>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
        <?php if (!$pets): ?>
            <p class="text-slate-500">No available pets found.</p>
        <?php endif; ?>
    </div>
</main>
<?php include "include/footer.php"; ?>
</body>
</html>
