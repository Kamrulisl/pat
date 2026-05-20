<?php $authUser = function_exists('currentUser') ? currentUser() : null; ?>
<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <a href="index.php" class="text-2xl font-bold">
                <span class="text-blue-600">Pet</span><span class="text-emerald-600">Pals</span>
            </a>
            <ul class="flex flex-wrap items-center gap-3 text-sm font-medium">
                <li><a href="index.php" class="hover:text-blue-600">Home</a></li>
                <li><a href="browse.php" class="hover:text-blue-600">Browse Pets</a></li>
                <?php if ($authUser): ?>
                    <li><a href="dashboard.php" class="hover:text-blue-600">Dashboard</a></li>
                    <li><a href="profile.php" class="hover:text-blue-600">Profile</a></li>
                    <li><a href="pass-change.php" class="hover:text-blue-600">Change Password</a></li>
                    <?php if ($authUser['role'] === 'admin'): ?>
                        <li><a href="admin/index.php" class="hover:text-blue-600">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Login</a></li>
                    <li><a href="register.php" class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
