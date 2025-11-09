<?php
// Load environment variables from the .env file
$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    die("Error: .env file missing. Please create one in the project root.");
}

// Parse .env file (read all key=value lines)
$env = parse_ini_file($envFile);

// Store DB info from .env
$host = $env['DB_HOST'];
$dbname = $env['DB_NAME'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];

// Try to connect using PDO (for secure DB access)
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Set PDO to throw errors if something goes wrong
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Show friendly error message if connection fails
    die("Database connection failed: " . $e->getMessage());
}
?>
