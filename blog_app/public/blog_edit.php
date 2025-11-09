<?php
session_start();
require_once('../includes/db_connect.php');

// Only logged-in users can edit
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Make sure the blog ID is provided
if (!isset($_GET['id'])) {
    die("Missing blog ID.");
}

$blog_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$errors = [];

// Fetch the blog to edit
try {
    $stmt = $pdo->prepare("SELECT * FROM blogpost WHERE id = ? AND user_id = ?");
    $stmt->execute([$blog_id, $user_id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$blog) {
        die("You can only edit your own blog posts or this post doesn't exist.");
    }
} catch (PDOException $e) {
    die("Error fetching blog: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $errors[] = "All fields are required.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE blogpost SET title = ?, content = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
            $stmt->execute([$title, $content, $blog_id, $user_id]);
            $_SESSION['message'] = "✏️ Blog updated successfully!";
            header("Location: blog_view.php?id=$blog_id");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Error updating blog: " . $e->getMessage();
        }
    }
}

include('../includes/header.php');
?>

<!-- Edit Blog Card -->
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Edit Your Blog</h2>

    <?php include('../includes/errors.php'); ?>

    <form method="POST">
        <!-- Title -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" name="title" required
                   value="<?php echo htmlspecialchars($blog['title']); ?>"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <!-- Content -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
            <textarea name="content" rows="8" required
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500"><?php echo htmlspecialchars($blog['content']); ?></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                Update Blog
            </button>
            <a href="blog_view.php?id=<?php echo $blog_id; ?>"
               class="text-gray-600 hover:text-gray-800 font-medium">Cancel</a>
        </div>
    </form>
</div>

<?php include('../includes/footer.php'); ?>

