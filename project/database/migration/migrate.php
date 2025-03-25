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
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
            
            "booking" => "CREATE TABLE IF NOT EXISTS booking (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(50) NOT NULL,
                middle_name VARCHAR(50) NULL,
                last_name VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                phone_number VARCHAR(20) NOT NULL,
                status ENUM('pending', 'confirmed', 'cancelled') NOT NULL DEFAULT 'pending',
                booking_schedule DATETIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",

            "products name" => "CREATE TABLE IF NOT EXISTS products_name (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",

            "products" => "CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                quantity INT NOT NULL,
                product_name VARCHAR(255) NOT NULL,
                date_expiration DATE NOT NULL,
                date_produce DATE NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                unit_of_price VARCHAR(50) NOT NULL,
                category VARCHAR(50) NOT NULL,
                status ENUM('new', 'old') NOT NULL DEFAULT 'new',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
                filename VARCHAR(255) NOT NULL,
                file_path VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
