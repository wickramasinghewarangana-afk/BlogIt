<?php
session_start();
require_once('../includes/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content)) {
        $errors[] = "Both fields are required.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO blogpost (user_id, title, content) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $title, $content]);
            $_SESSION['message'] = "✅ Blog created successfully!";
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Error creating post: " . $e->getMessage();
        }
    }
}

include('../includes/header.php');
?>

<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Create a New Blog</h2>

    <?php include('../includes/errors.php'); ?>

    <form method="POST">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" name="title" required
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
            <textarea name="content" rows="8" required
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500"></textarea>
        </div>
        <button type="submit"
                class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
            Publish Blog
        </button>
        <a href="index.php" class="ml-4 text-gray-600 hover:text-gray-800 font-medium">Cancel</a>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
