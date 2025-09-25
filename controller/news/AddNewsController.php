<?php

session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}

$title = htmlspecialchars(trim($_POST["title"] ?? ""), ENT_QUOTES, 'UTF-8');
$content = htmlspecialchars(trim($_POST["content"] ?? ""), ENT_QUOTES, 'UTF-8');

$errors = [];

if (empty($title)) $errors[] = "Title is required.";
if (empty($content)) $errors[] = "Content is required.";

$imagePath = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['image'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        $errors[] = "Only JPG, PNG, WebP, and GIF images are allowed.";
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        $errors[] = "Image must be less than 5MB.";
    }

    if (empty($errors)) {
        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
        $uniqueName = $safeName . '_' . uniqid() . '.' . $extension;

        $uploadDir = __DIR__ . '/../../public/storage/news/';
        $fullPath = $uploadDir . $uniqueName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $fullPath)) {
            $imagePath = '/public/storage/news/' . $uniqueName;
        } else {
            $errors[] = "Failed to save uploaded image.";
        }
    }
} elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
    $errors[] = "Image upload error: " . $_FILES['image']['error'];
}

if (!empty($errors)) {
    echo json_encode(["error" => true, "messages" => $errors]);
    exit;
}

$sql = "INSERT INTO news (title, content, image_path) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(["error" => true, "message" => "Database prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("sss", $title, $content, $imagePath);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "News added successfully.",
    ]);
} else {
    if ($imagePath) {
        $filePath = __DIR__ . '/../../' . $imagePath;
        if (file_exists($filePath)) @unlink($filePath);
    }
    echo json_encode(["error" => true, "message" => "Database insert failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
exit;