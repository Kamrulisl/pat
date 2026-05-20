<?php
$conn = mysqli_connect("localhost", "root", "", "PetSelling");
$con = $conn;

if (!$conn) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

function processImageUpload($image, $filePath) {
    if (!isset($image['error']) || $image['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    if (!is_dir($filePath)) {
        mkdir($filePath, 0755, true);
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExtensions, true)) {
        return null;
    }

    $imageName = md5(date("Y-m-d H:i:s") . uniqid('', true)) . "." . $ext;
    $destination = rtrim($filePath, "/\\") . DIRECTORY_SEPARATOR . $imageName;

    if (move_uploaded_file($image['tmp_name'], $destination)) {
        return $imageName;
    }

    return null;
}
?>
