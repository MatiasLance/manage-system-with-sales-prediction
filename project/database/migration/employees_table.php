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
        $sql = "CREATE TABLE employees (
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
            );";

        if ($this->conn->query($sql) === TRUE) {
            echo "Table `Employees` migrated successfully.\n";
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
