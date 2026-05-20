<?php
$authUser = function_exists('currentUser') ? currentUser() : null;
$authAdmin = function_exists('currentAdmin') ? currentAdmin() : null;
$page = basename($_SERVER['SCRIPT_NAME']);
$panel = $_GET['panel'] ?? '';
$adminContext = $panel === 'admin' || strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false || in_array($page, ['add-pet.php', 'my-pets.php'], true);
$userContext = $panel === 'user' || strpos($_SERVER['SCRIPT_NAME'], '/user/') !== false || in_array($page, ['profile.php', 'pass-change.php'], true);
$showAdminMenu = $authAdmin && (!$userContext || $adminContext);
$showUserMenu = $authUser && (!$adminContext || $userContext);
$browsePanel = $adminContext ? '?panel=admin' : ($userContext ? '?panel=user' : '');
?>
<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <a href="index.php" class="text-2xl font-bold">
                <span class="text-blue-600">Pet</span><span class="text-emerald-600">Pals</span>
            </a>
            <ul class="flex flex-wrap items-center gap-3 text-sm font-medium">
                <li><a href="index.php" class="hover:text-blue-600">Home</a></li>
                <li><a href="browse.php<?= $browsePanel ?>" class="hover:text-blue-600">Browse Pets</a></li>
                <?php if ($authUser || $authAdmin): ?>
                    <?php if ($showAdminMenu): ?>
                        <li><a href="admin/index.php" class="hover:text-blue-600">Admin</a></li>
                        <li><a href="admin/logout.php" class="text-red-600 hover:text-red-700">Admin Logout</a></li>
                    <?php endif; ?>
                    <?php if ($showUserMenu): ?>
                        <li><a href="user/index.php" class="hover:text-blue-600">User Panel</a></li>
                        <li><a href="profile.php" class="hover:text-blue-600">Profile</a></li>
                        <li><a href="pass-change.php" class="hover:text-blue-600">Change Password</a></li>
                        <li><a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Logout</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="login.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Login</a></li>
                    <li><a href="admin/login.php" class="border border-slate-300 px-4 py-2 rounded-md hover:border-blue-600">Admin Login</a></li>
                    <li><a href="register.php" class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
