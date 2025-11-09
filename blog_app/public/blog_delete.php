<?php
session_start();
require_once('../includes/db_connect.php');

// Only logged-in users can delete
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Blog ID missing.");
}

$blog_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

try {
    // Verify ownership
    $stmt = $pdo->prepare("SELECT * FROM blogpost WHERE id = ? AND user_id = ?");
    $stmt->execute([$blog_id, $user_id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$blog) {
        die("You can only delete your own blog posts.");
    }

    // Delete blog
    $stmt = $pdo->prepare("DELETE FROM blogpost WHERE id = ? AND user_id = ?");
    $stmt->execute([$blog_id, $user_id]);

    // Success message
    $_SESSION['message'] = "🗑️ Blog post deleted successfully!";
    header("Location: index.php");
    exit;

} catch (PDOException $e) {
    die("Error deleting blog: " . $e->getMessage());
}
