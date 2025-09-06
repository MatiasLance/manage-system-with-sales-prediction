<?php

session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}

$newsId = intval($_POST["id"] ?? 0);
$title = htmlspecialchars(trim($_POST["title"] ?? ""), ENT_QUOTES, 'UTF-8');
$content = htmlspecialchars(trim($_POST["content"] ?? ""), ENT_QUOTES, 'UTF-8');

$errors = [];

if ($newsId <= 0) {
    $errors[] = "Invalid news ID.";
}
if (empty($title)) {
    $errors[] = "Title is required.";
}
if (empty($content)) {
    $errors[] = "Content is required.";
}

if (!empty($errors)) {
    echo json_encode(["error" => true, "messages" => $errors]);
    exit;
}

$imagePath = null;
$uploadDir = __DIR__ . '/../../public/storage/news/';
$webPath = '/public/storage/news/';

$shouldUpdateImage = isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE;

if ($shouldUpdateImage) {
    $file = $_FILES['image'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "File upload error: " . $file['error'];
    } else {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($mimeType, $allowedTypes)) {
            $errors[] = "Only JPG, PNG, GIF, and WebP images are allowed.";
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            $errors[] = "Image must be less than 5MB.";
        }

        if (empty($errors)) {
            $fileContent = file_get_contents($file['tmp_name']);
            $fileHash = hash('sha256', $fileContent);

            $checkSql = "SELECT image_path FROM news WHERE id != ? AND image_path IS NOT NULL";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("i", $newsId);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $existingPath = __DIR__ . '/../../' . $row['image_path'];
                if (file_exists($existingPath)) {
                    $existingContent = file_get_contents($existingPath);
                    if (hash('sha256', $existingContent) === $fileHash) {
                        $imagePath = $row['image_path'];
                        break;
                    }
                }
            }
            $checkStmt->close();

            if ($imagePath === null) {
                $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
                $uniqueName = $safeName . '_' . uniqid() . '.' . $extension;
                $fullPath = $uploadDir . $uniqueName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (move_uploaded_file($file['tmp_name'], $fullPath)) {
                    $imagePath = $webPath . $uniqueName;
                } else {
                    $errors[] = "Failed to save image.";
                }
            }
        }
    }
}

if (!empty($errors)) {
    echo json_encode(["error" => true, "messages" => $errors]);
    exit;
}

$oldImagePath = null;
$fetchSql = "SELECT image_path FROM news WHERE id = ?";
$fetchStmt = $conn->prepare($fetchSql);
$fetchStmt->bind_param("i", $newsId);
$fetchStmt->execute();
$fetchResult = $fetchStmt->get_result();

if ($fetchResult->num_rows === 0) {
    echo json_encode(["error" => true, "message" => "News not found."]);
    $fetchStmt->close();
    $conn->close();
    exit;
}

$row = $fetchResult->fetch_assoc();
$oldImagePath = $row['image_path'];
$fetchStmt->close();

if ($shouldUpdateImage) {
    $sql = "UPDATE news SET title = ?, content = ?, image_path = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $content, $imagePath, $newsId);
} else {
    $sql = "UPDATE news SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $newsId);
}

if ($stmt === false) {
    echo json_encode(["error" => true, "message" => "Database prepare failed: " . $conn->error]);
    $conn->close();
    exit;
}

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        if ($oldImagePath && $oldImagePath !== $imagePath) {
            $oldFilePath = __DIR__ . '/../../' . $oldImagePath;
            if (file_exists($oldFilePath)) {
                @unlink($oldFilePath);
            }
        }

        echo json_encode([
            "success" => true,
            "message" => "News updated successfully.",
        ]);
    } else {
        echo json_encode(["error" => true, "message" => "No changes were made or news not found."]);
    }
} else {
    echo json_encode(["error" => true, "message" => "Update failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
exit;