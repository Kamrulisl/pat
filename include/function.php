<?php
require_once __DIR__ . "/connection.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function currentUser() {
    global $conn;

    if (empty($_SESSION['user_id'])) {
        return null;
    }

    $user_id = (int) $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT * FROM Users WHERE user_id=$user_id LIMIT 1");
    return $result ? mysqli_fetch_assoc($result) : null;
}

function currentAdmin() {
    global $conn;

    if (empty($_SESSION['admin_id'])) {
        return null;
    }

    $admin_id = (int) $_SESSION['admin_id'];
    $result = mysqli_query($conn, "SELECT * FROM Admins WHERE admin_id=$admin_id LIMIT 1");
    return $result ? mysqli_fetch_assoc($result) : null;
}

function requireLogin($role = null) {
    $user = currentUser();

    if (!$user) {
        header("Location: login.php");
        exit();
    }

    return $user;
}

function requireAdmin() {
    $admin = currentAdmin();

    if (!$admin) {
        $loginPath = strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false ? 'login.php' : 'admin/login.php';
        header("Location: $loginPath");
        exit();
    }

    return $admin;
}

function getAllCategories() {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM Categories ORDER BY category_name");
    $categories = [];
    while ($result && $row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}

function getPets($where = "1=1") {
    global $conn;
    $sql = "SELECT Pets.*, Categories.category_name, Admins.full_name AS admin_name, Admins.phone_number AS admin_phone
            FROM Pets
            JOIN Categories ON Categories.category_id = Pets.category_id
            JOIN Admins ON Admins.admin_id = Pets.admin_id
            WHERE $where
            ORDER BY Pets.created_at DESC";
    $result = mysqli_query($conn, $sql);
    $pets = [];
    while ($result && $row = mysqli_fetch_assoc($result)) {
        $pets[] = $row;
    }
    return $pets;
}

function getPetById($pet_id) {
    global $conn;
    $pet_id = (int) $pet_id;
    $result = mysqli_query($conn, "SELECT * FROM Pets WHERE pet_id=$pet_id LIMIT 1");
    return $result ? mysqli_fetch_assoc($result) : null;
}

function changePassword($user_id, $new_password) {
    global $conn;
    $user_id = (int) $user_id;
    $password_hash = md5($new_password);
    return mysqli_query($conn, "UPDATE Users SET password_hash='$password_hash' WHERE user_id=$user_id");
}

function changeAdminPassword($admin_id, $new_password) {
    global $conn;
    $admin_id = (int) $admin_id;
    $password_hash = md5($new_password);
    return mysqli_query($conn, "UPDATE Admins SET password_hash='$password_hash' WHERE admin_id=$admin_id");
}
?>
