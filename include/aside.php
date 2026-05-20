<?php
$authUser = function_exists('currentUser') ? currentUser() : null;
$authAdmin = function_exists('currentAdmin') ? currentAdmin() : null;
$prefix = (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/user/') !== false) ? '../' : '';
?>
<aside class="bg-slate-900 text-white rounded-lg p-5">
    <h3 class="text-lg font-bold mb-4">Menu</h3>
    <ul class="space-y-3 text-sm">
        <li><a href="<?= $prefix ?>browse.php" class="block hover:text-emerald-300"><i class="fas fa-paw mr-2"></i>Browse Pets</a></li>
        <?php if ($authAdmin): ?>
            <li><a href="<?= $prefix ?>admin/index.php" class="block hover:text-emerald-300"><i class="fas fa-shield-halved mr-2"></i>Admin Panel</a></li>
            <li><a href="<?= $prefix ?>add-pet.php" class="block hover:text-emerald-300"><i class="fas fa-plus mr-2"></i>Add Product</a></li>
            <li><a href="<?= $prefix ?>my-pets.php" class="block hover:text-emerald-300"><i class="fas fa-list mr-2"></i>Admin Products</a></li>
        <?php endif; ?>
        <?php if ($authUser): ?>
            <li><a href="<?= $prefix ?>user/index.php" class="block hover:text-emerald-300"><i class="fas fa-gauge mr-2"></i>User Panel</a></li>
            <li><a href="<?= $prefix ?>orders.php" class="block hover:text-emerald-300"><i class="fas fa-receipt mr-2"></i>Orders</a></li>
            <li><a href="<?= $prefix ?>profile.php" class="block hover:text-emerald-300"><i class="fas fa-user mr-2"></i>Profile</a></li>
            <li><a href="<?= $prefix ?>pass-change.php" class="block hover:text-emerald-300"><i class="fas fa-key mr-2"></i>Change Password</a></li>
            <li><a href="<?= $prefix ?>logout.php" class="block text-red-200 hover:text-red-100"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a></li>
        <?php endif; ?>
        <?php if ($authAdmin): ?>
            <li><a href="<?= $prefix ?>admin/logout.php" class="block text-red-200 hover:text-red-100"><i class="fas fa-sign-out-alt mr-2"></i>Admin Logout</a></li>
        <?php endif; ?>
    </ul>
</aside>
