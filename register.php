<?php
require_once "include/function.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, trim($_POST['username'] ?? ''));
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name'] ?? ''));
    $phone_number = mysqli_real_escape_string($conn, trim($_POST['phone_number'] ?? ''));
    $city = mysqli_real_escape_string($conn, trim($_POST['city'] ?? ''));

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $profile_picture = !empty($_FILES['profile_picture']['name'])
            ? processImageUpload($_FILES['profile_picture'], "uploads/user/")
            : null;
        $password_hash = md5($password);

        $sql = "INSERT INTO Users (username, email, password_hash, full_name, phone_number, profile_picture, city)
                VALUES ('$username', '$email', '$password_hash', '$full_name', '$phone_number', '$profile_picture', '$city')";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php?registered=1");
            exit();
        }

        $error = mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PetPals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main class="max-w-7xl mx-auto px-4 py-10">
    <div class="max-w-4xl mx-auto bg-white border border-slate-200 rounded-lg p-8 shadow-sm">
        <h1 class="text-3xl font-bold mb-2">Create Account</h1>
        <p class="text-slate-500 mb-6">Create a user account to buy pets.</p>
        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 border border-red-200 rounded-md px-4 py-3 mb-5"><?= h($error) ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block font-medium mb-2">Username</label>
                <input class="w-full border rounded-md px-4 py-3" name="username" required>
            </div>
            <div>
                <label class="block font-medium mb-2">Email</label>
                <input class="w-full border rounded-md px-4 py-3" name="email" type="email" required>
            </div>
            <div>
                <label class="block font-medium mb-2">Password</label>
                <input class="w-full border rounded-md px-4 py-3" name="password" type="password" required>
            </div>
            <div>
                <label class="block font-medium mb-2">Confirm Password</label>
                <input class="w-full border rounded-md px-4 py-3" name="confirm_password" type="password" required>
            </div>
            <div>
                <label class="block font-medium mb-2">Full Name</label>
                <input class="w-full border rounded-md px-4 py-3" name="full_name" required>
            </div>
            <div>
                <label class="block font-medium mb-2">Phone Number</label>
                <input class="w-full border rounded-md px-4 py-3" name="phone_number">
            </div>
            <div>
                <label class="block font-medium mb-2">City</label>
                <select class="w-full border rounded-md px-4 py-3" name="city">
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chattogram">Chattogram</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Sylhet">Sylhet</option>
                </select>
            </div>
            <div>
                <label class="block font-medium mb-2">Profile Picture</label>
                <input class="w-full border rounded-md px-4 py-3 bg-white" name="profile_picture" type="file" accept="image/*">
            </div>
            <button class="md:col-span-2 bg-emerald-600 text-white font-bold py-3 rounded-md hover:bg-emerald-700">Create Account</button>
        </form>
    </div>
</main>
<?php include "include/footer.php"; ?>
</body>
</html>
