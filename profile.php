<?php
require_once "include/function.php";
$panelContext = 'user';
$user = requireLogin();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name'] ?? ''));
    $phone_number = mysqli_real_escape_string($conn, trim($_POST['phone_number'] ?? ''));
    $city = mysqli_real_escape_string($conn, trim($_POST['city'] ?? ''));
    $profile_picture = $user['profile_picture'];

    if (!empty($_FILES['profile_picture']['name'])) {
        $uploaded = processImageUpload($_FILES['profile_picture'], "uploads/user/");
        if ($uploaded) {
            $profile_picture = $uploaded;
        }
    }

    $user_id = (int) $user['user_id'];
    if (mysqli_query($conn, "UPDATE Users SET full_name='$full_name', phone_number='$phone_number', city='$city', profile_picture='$profile_picture' WHERE user_id=$user_id")) {
        $message = "Profile updated successfully.";
        $user = currentUser();
    } else {
        $message = mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Profile - PetPals</title><script src="https://cdn.tailwindcss.com"></script><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"></head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[240px_1fr] gap-6">
<?php include "include/aside.php"; ?>
<section class="bg-white border rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6">Profile</h1>
    <?php if ($message): ?><div class="bg-blue-50 text-blue-700 border border-blue-200 rounded-md px-4 py-3 mb-5"><?= h($message) ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-5">
        <div class="md:col-span-2 flex items-center gap-4">
            <img class="w-20 h-20 rounded-full object-cover bg-slate-100" src="<?= $user['profile_picture'] ? 'uploads/user/' . h($user['profile_picture']) : 'uploads/admin.jpg' ?>" alt="Profile">
            <input class="border rounded-md px-4 py-3" name="profile_picture" type="file" accept="image/*">
        </div>
        <div><label class="block mb-2 font-medium">Full Name</label><input class="w-full border rounded-md px-4 py-3" name="full_name" value="<?= h($user['full_name']) ?>"></div>
        <div><label class="block mb-2 font-medium">Email</label><input class="w-full border rounded-md px-4 py-3 bg-slate-100" value="<?= h($user['email']) ?>" readonly></div>
        <div><label class="block mb-2 font-medium">Phone</label><input class="w-full border rounded-md px-4 py-3" name="phone_number" value="<?= h($user['phone_number']) ?>"></div>
        <div><label class="block mb-2 font-medium">City</label><input class="w-full border rounded-md px-4 py-3" name="city" value="<?= h($user['city'] ?? '') ?>"></div>
        <button class="md:col-span-2 bg-blue-600 text-white font-bold py-3 rounded-md">Update Profile</button>
    </form>
</section>
</main>
<?php include "include/footer.php"; ?>
</body></html>
