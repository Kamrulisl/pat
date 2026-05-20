<?php $authUser = function_exists('currentUser') ? currentUser() : null; ?>
<aside class="bg-slate-900 text-white rounded-lg p-5">
    <h3 class="text-lg font-bold mb-4">Menu</h3>
    <ul class="space-y-3 text-sm">
        <li><a href="dashboard.php" class="block hover:text-emerald-300"><i class="fas fa-gauge mr-2"></i>Dashboard</a></li>
        <li><a href="browse.php" class="block hover:text-emerald-300"><i class="fas fa-paw mr-2"></i>Browse Pets</a></li>
        <?php if ($authUser && $authUser['role'] === 'seller'): ?>
            <li><a href="add-pet.php" class="block hover:text-emerald-300"><i class="fas fa-plus mr-2"></i>Add Pet</a></li>
            <li><a href="my-pets.php" class="block hover:text-emerald-300"><i class="fas fa-list mr-2"></i>My Pets</a></li>
        <?php endif; ?>
        <?php if ($authUser): ?>
            <li><a href="orders.php" class="block hover:text-emerald-300"><i class="fas fa-receipt mr-2"></i>Orders</a></li>
            <li><a href="profile.php" class="block hover:text-emerald-300"><i class="fas fa-user mr-2"></i>Profile</a></li>
            <li><a href="pass-change.php" class="block hover:text-emerald-300"><i class="fas fa-key mr-2"></i>Change Password</a></li>
            <li><a href="logout.php" class="block text-red-200 hover:text-red-100"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a></li>
        <?php endif; ?>
    </ul>
</aside>
