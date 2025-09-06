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
        $tables = [
            "employees" => "CREATE TABLE IF NOT EXISTS employees (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(100) NOT NULL,
                middle_initial VARCHAR(100),
                last_name VARCHAR(100) NOT NULL,
                working_department VARCHAR(100),
                phone_number VARCHAR(15),
                date_of_hire DATE,
                job VARCHAR(100),
                educational_level VARCHAR(100),
                gender ENUM('Male', 'Female', 'Other') NOT NULL,
                date_of_birth DATE,
                salary DECIMAL(10, 2) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
            
            "booking" => "CREATE TABLE IF NOT EXISTS booking (
                id INT AUTO_INCREMENT PRIMARY KEY,
                room_id INT DEFAULT NULL,
                first_name VARCHAR(50) NOT NULL,
                middle_name VARCHAR(50) DEFAULT NULL,
                last_name VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL,
                phone_number VARCHAR(20) NOT NULL,
                status ENUM('pending', 'confirmed', 'cancelled', 'done') NOT NULL DEFAULT 'pending',
                guest_count INT NOT NULL,
                start_date DATETIME NOT NULL,
                end_date   DATETIME NOT NULL,
                check_in TIME DEFAULT NULL,
                check_out TIME DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (room_id) REFERENCES room(id)
            )",

            "room" => "CREATE TABLE IF NOT EXISTS room (
                id INT AUTO_INCREMENT PRIMARY KEY,
                room_number VARCHAR(50) NOT NULL,
                status ENUM('available', 'occupied') NOT NULL DEFAULT 'available',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            "products name" => "CREATE TABLE IF NOT EXISTS products_name (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_name VARCHAR(255) NOT NULL,
                product_code VARCHAR(255) NOT NULL,
                product_category VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",

            "products" => "CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                total_quantity INT NOT NULL,
                added_quantity INT NOT NULL,
                product_name_id INT NOT NULL,
                date_produce DATE NOT NULL,
                date_expiration DATE NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                unit_of_price VARCHAR(50) NOT NULL,
                barcode VARCHAR(255) UNIQUE NOT NULL COMMENT 'Unique barcode identifier (e.g., generated from name + random)',
                barcode_image VARCHAR(500) NOT NULL COMMENT 'File path to saved barcode PNG image',
                status ENUM('new', 'old') NOT NULL DEFAULT 'new',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT FK_ProductNameID FOREIGN KEY (product_name_id) REFERENCES products_name(id) ON DELETE RESTRICT ON UPDATE CASCADE
            )",

            "users" => "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(50) NOT NULL,
                lastname VARCHAR(50) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                user_type ENUM('admin', 'user') NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            "media" => "CREATE TABLE IF NOT EXISTS media (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT DEFAULT NULL,
                employee_id INT DEFAULT NULL,
                filename VARCHAR(255) NOT NULL,
                file_path VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(id),
                FOREIGN KEY (employee_id) REFERENCES employees(id)
            )",

            "archived products" => "CREATE TABLE IF NOT EXISTS archived_products (
                id INT PRIMARY KEY,
                total_quantity INT NOT NULL,
                added_quantity INT NOT NULL,
                product_name_id INT NOT NULL,
                date_produce DATE NOT NULL,
                date_expiration DATE NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                unit_of_price VARCHAR(50) NOT NULL,
                status ENUM('new', 'old') NOT NULL,
                created_at TIMESTAMP,
                updated_at TIMESTAMP,
                deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_name_id) REFERENCES products_name(id)
            )",

            "orders" => "CREATE TABLE IF NOT EXISTS orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_number VARCHAR(50) NOT NULL,
                quantity INT NOT NULL,
                product_name VARCHAR(255) NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                unit_of_price VARCHAR(50) NOT NULL,
                tax_amount DECIMAL(10,2) NOT NULL,
                total DECIMAL(10,2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP
            )",

            "news" => "CREATE TABLE IF NOT EXISTS news (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                image_path VARCHAR(512) NULL DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP
            )"
        ];

        foreach ($tables as $tableName => $sql) {
            if ($this->conn->query($sql) === TRUE) {
                echo "Table `$tableName` migrated successfully.\n";
            } else {
                echo "Error migrating table `$tableName`: " . $this->conn->error . "\n";
            }
        }
    }
}

// Command-line arguments
$arguments = getopt("f:", ["migrate"]);
$migrator = new DatabaseMigrator($conn);

if (isset($arguments['migrate'])) {
    $migrator->migrate();
}
?>
