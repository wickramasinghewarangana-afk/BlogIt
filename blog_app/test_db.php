<?php
$host = 'sql102.infinityfree.com';
$db   = 'if0_40351018_blog_db';
$user = 'if0_40351018';
$pass = 'your_real_password_here';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
