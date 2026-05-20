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

function requireLogin($role = null) {
    $user = currentUser();

    if (!$user) {
        header("Location: login.php");
        exit();
    }

    if ($role && $user['role'] !== $role) {
        header("Location: dashboard.php");
        exit();
    }

    return $user;
}

function requireAdmin() {
    $user = currentUser();

    if (!$user || $user['role'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }

    return $user;
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
    $sql = "SELECT Pets.*, Categories.category_name, Users.full_name AS seller_name, Users.phone_number AS seller_phone
            FROM Pets
            JOIN Categories ON Categories.category_id = Pets.category_id
            JOIN Users ON Users.user_id = Pets.seller_id
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
?>
