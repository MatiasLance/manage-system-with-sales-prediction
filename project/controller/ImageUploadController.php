<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

$action = $_POST['action'] ?? '';

switch($action){
    case 'create':
        // Check if file is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = "../public/storage/media/";

            // Validate file extension and size
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB

            $fileTmpPath = $_FILES['image']['tmp_name'];
            $originalFileName = $_FILES['image']['name'];
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedExtensions)) {
                echo json_encode(["status" => "error", "message" => "Invalid file extension"]);
                exit;
            }

            if ($_FILES['image']['size'] > $maxFileSize) {
                echo json_encode(["status" => "error", "message" => "File size exceeds the limit"]);
                exit;
            }

            // Ensure upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Check if an image with the same original filename exists
            $stmt = $conn->prepare("SELECT file_path FROM media WHERE filename = ? LIMIT 1");
            $stmt->bind_param("s", $originalFileName);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($existingFilePath);
                $stmt->fetch();

                // Delete the old image file if it exists
                if (file_exists($existingFilePath)) {
                    unlink($existingFilePath);
                }

                // Delete the old database record
                $stmtDelete = $conn->prepare("DELETE FROM media WHERE filename = ?");
                $stmtDelete->bind_param("s", $originalFileName);
                $stmtDelete->execute();
                $stmtDelete->close();
            }
            $stmt->close();

            // Generate a unique file name to avoid conflicts
            $fileName = uniqid() . "_" . $originalFileName;
            $filePath = $uploadDir . $fileName;

            // Get image info
            list($width, $height, $type) = getimagesize($fileTmpPath);

            // Load image & compress
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $image = @imagecreatefromjpeg($fileTmpPath);
                    if (!$image) {
                        echo json_encode(["status" => "error", "message" => "Invalid or corrupted JPEG image"]);
                        exit;
                    }
                    imagejpeg($image, $filePath, 70); // Compress to 70%
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($fileTmpPath);
                    imagepng($image, $filePath, 7); // Compress (0-9, lower is better)
                    break;
                case IMAGETYPE_WEBP:
                    $image = imagecreatefromwebp($fileTmpPath);
                    imagewebp($image, $filePath, 70); // Compress to 70%
                    break;
                default:
                    echo json_encode(["status" => "error", "message" => "Invalid image type"]);
                    exit;
            }
            imagedestroy($image);

            // Save new image to database
            $stmtInsert = $conn->prepare("INSERT INTO media (filename, file_path) VALUES (?, ?)");
            $stmtInsert->bind_param("ss", $fileName, $filePath);

            if ($stmtInsert->execute()) {
                $_SESSION['sidebar_menu_logo'] = $filePath;
                echo json_encode(["status" => "success", "message" => "Image uploaded successfully", "file" => $filePath]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error"]);
            }

            $stmtInsert->close();
        } else {
            echo json_encode(["status" => "error", "message" => "File upload error"]);
        }
    break;
    case 'update':
        // Update existing image
    break;
}


$conn->close();