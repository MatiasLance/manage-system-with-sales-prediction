<?php
require_once __DIR__ . '/../../config/db_connection.php';

class DatabaseMigrator
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function migrate()
    {
        $sql = "CREATE TABLE IF NOT EXISTS archive_product_data(
            id INT AUTO_INCREMENT PRIMARY KEY,
            quantity INT NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            barcode VARCHAR(100) UNIQUE NOT NULL,
            barcode_image VARCHAR(255) NOT NULL,
            date_expiration DATE NOT NULL,
            date_produce DATE NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            product_status ENUM('new', 'old') NOT NULL DEFAULT 'new',
            unit_of_price VARCHAR(50) NOT NULL,
            archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if ($this->conn->query($sql) === TRUE) {
            echo "Table `archive` migrated successfully.\n";
        } else {
            echo "Error migrating table: " . $this->conn->error . "\n";
        }
    }
}

// Command-line arguments
$arguments = getopt("f:", ["migrate"]);
$migrator = new DatabaseMigrator($conn);

if (isset($arguments['migrate'])) {
    $migrator->migrate();
}
