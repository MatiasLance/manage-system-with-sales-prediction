<?php
require_once __DIR__ . '/../../config/db_connection.php';

class DatabaseSeeder
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function seed()
    {
        $passwordHash = password_hash('superadmin1', PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (firstname, lastname, email, password, user_type) VALUES
            ('admin', 'mbrlcfi', 'admin@rmc.com', '$passwordHash', 'admin'),
            ('Jane', 'Smith', 'cashier@rmc.com', '$passwordHash', 'cashier'),
            ('John', 'Doe', 'manager.@rmc.com', '$passwordHash', 'manager')";

        if ($this->conn->query($sql) === TRUE) {
            echo "Data seeded successfully.\n";
        } else {
            echo "Error seeding data: " . $this->conn->error . "\n";
        }
    }
}

// Command-line arguments
$arguments = getopt("f:", ["seed"]);
$seeder = new DatabaseSeeder($conn);

if (isset($arguments['seed'])) {
    $seeder->seed();
}