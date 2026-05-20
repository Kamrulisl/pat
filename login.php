<?php
require_once "include/function.php";

if (currentUser()) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = md5($_POST['password'] ?? '');

    $result = mysqli_query($conn, "SELECT * FROM Users WHERE email='$email' AND password_hash='$password' LIMIT 1");

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        header("Location: " . ($user['role'] === 'admin' ? "admin/index.php" : "dashboard.php"));
        exit();
    }

    $error = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PetPals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800">
<?php include "include/header.php"; ?>
<main class="max-w-7xl mx-auto px-4 py-10">
    <div class="max-w-md mx-auto bg-white border border-slate-200 rounded-lg p-8 shadow-sm">
        <h1 class="text-3xl font-bold mb-2">Login</h1>
        <p class="text-slate-500 mb-6">Use your admin/seller or user/buyer account.</p>
        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 border border-red-200 rounded-md px-4 py-3 mb-5"><?= h($error) ?></div>
        <?php endif; ?>
        <form method="POST" class="space-y-5">
            <div>
                <label class="block font-medium mb-2" for="email">Email</label>
                <input class="w-full border border-slate-300 rounded-md px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" id="email" name="email" type="email" required>
            </div>
            <div>
                <label class="block font-medium mb-2" for="password">Password</label>
                <input class="w-full border border-slate-300 rounded-md px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" id="password" name="password" type="password" required>
            </div>
            <button class="w-full bg-blue-600 text-white font-bold py-3 rounded-md hover:bg-blue-700" type="submit">Login</button>
        </form>
        <p class="text-center mt-5 text-sm">No account? <a class="text-blue-600 font-semibold" href="register.php">Register here</a></p>
    </div>
</main>
<?php include "include/footer.php"; ?>
</body>
</html>
