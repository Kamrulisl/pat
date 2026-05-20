<?php
require_once "../include/function.php";

if (currentAdmin()) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = md5($_POST['password'] ?? '');

    $result = mysqli_query($conn, "SELECT * FROM Admins WHERE email='$email' AND password_hash='$password' LIMIT 1");

    if ($result && mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_email'] = $admin['email'];
        header("Location: index.php");
        exit();
    }

    $error = "Invalid admin email or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - PetPals</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-800 min-h-screen flex items-center justify-center px-4">
    <main class="w-full max-w-md bg-white rounded-lg p-8">
        <h1 class="text-3xl font-bold mb-2">Admin Login</h1>
        <p class="text-slate-500 mb-6">Login to sell pets and manage orders.</p>
        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 border border-red-200 rounded-md px-4 py-3 mb-5"><?= h($error) ?></div>
        <?php endif; ?>
        <form method="POST" class="space-y-5">
            <div>
                <label class="block font-medium mb-2">Email</label>
                <input class="w-full border rounded-md px-4 py-3" name="email" type="email" required>
            </div>
            <div>
                <label class="block font-medium mb-2">Password</label>
                <input class="w-full border rounded-md px-4 py-3" name="password" type="password" required>
            </div>
            <button class="w-full bg-slate-900 text-white font-bold py-3 rounded-md">Login</button>
        </form>
        <p class="text-center mt-5 text-sm"><a class="text-blue-600 font-semibold" href="../login.php">User login</a></p>
    </main>
</body>
</html>
