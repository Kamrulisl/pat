<?php
require_once "include/function.php";
$user = requireLogin();
if ($user['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
$categories = getAllCategories();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = (int) $user['user_id'];
    $category_id = (int) $_POST['category_id'];
    $pet_name = mysqli_real_escape_string($conn, trim($_POST['pet_name']));
    $breed = mysqli_real_escape_string($conn, trim($_POST['breed']));
    $age = (int) $_POST['age'];
    $gender = in_array($_POST['gender'], ['male', 'female'], true) ? $_POST['gender'] : 'male';
    $price = (float) $_POST['price'];
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $pet_image = !empty($_FILES['pet_image']['name']) ? processImageUpload($_FILES['pet_image'], "uploads/doc/") : null;

    $sql = "INSERT INTO Pets (admin_id, category_id, pet_name, breed, age, gender, price, description, pet_image)
            VALUES ($admin_id, $category_id, '$pet_name', '$breed', $age, '$gender', $price, '$description', '$pet_image')";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin/index.php");
        exit();
    }
    $error = mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Add Pet - PetPals</title><script src="https://cdn.tailwindcss.com"></script><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"></head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[240px_1fr] gap-6">
<?php include "include/aside.php"; ?>
<section class="bg-white border rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6">Add Product / Pet</h1>
    <?php if ($error): ?><div class="bg-red-50 text-red-700 border rounded-md px-4 py-3 mb-5"><?= h($error) ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-5">
        <div class="md:col-span-2 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-md px-4 py-3">This product will be listed by Admin.</div>
        <input class="border rounded-md px-4 py-3" name="pet_name" placeholder="Product / pet name" required>
        <select class="border rounded-md px-4 py-3" name="category_id" required><?php foreach ($categories as $cat): ?><option value="<?= (int) $cat['category_id'] ?>"><?= h($cat['category_name']) ?></option><?php endforeach; ?></select>
        <input class="border rounded-md px-4 py-3" name="breed" placeholder="Breed">
        <input class="border rounded-md px-4 py-3" name="age" type="number" min="0" placeholder="Age in months" required>
        <select class="border rounded-md px-4 py-3" name="gender"><option value="male">Male</option><option value="female">Female</option></select>
        <input class="border rounded-md px-4 py-3" name="price" type="number" min="0" step="0.01" placeholder="Price" required>
        <input class="border rounded-md px-4 py-3 md:col-span-2" name="pet_image" type="file" accept="image/*">
        <textarea class="border rounded-md px-4 py-3 md:col-span-2" name="description" rows="4" placeholder="Description"></textarea>
        <button class="md:col-span-2 bg-emerald-600 text-white font-bold py-3 rounded-md">Save Pet</button>
    </form>
</section>
</main>
<?php include "include/footer.php"; ?>
</body></html>
