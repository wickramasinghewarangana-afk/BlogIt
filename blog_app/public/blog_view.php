<?php
session_start();
require_once('../includes/db_connect.php');

// Check for blog ID
if (!isset($_GET['id'])) {
    die("Blog ID missing.");
}

$blog_id = $_GET['id'];

// Fetch blog details
try {
    $stmt = $pdo->prepare("SELECT blogpost.*, user.username 
                           FROM blogpost 
                           JOIN user ON blogpost.user_id = user.id 
                           WHERE blogpost.id = ?");
    $stmt->execute([$blog_id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$blog) {
        die("Blog not found.");
    }
} catch (PDOException $e) {
    die("Error loading blog: " . $e->getMessage());
}

include('../includes/header.php');
?>

<!-- Blog View -->
<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
        <?php echo htmlspecialchars($blog['title']); ?>
    </h1>

    <div class="flex justify-between items-center text-sm text-gray-500 mb-6">
        <span>By <span class="font-medium text-gray-700"><?php echo htmlspecialchars($blog['username']); ?></span></span>
        <time datetime="<?php echo $blog['created_at']; ?>">
            <?php echo date("M d, Y", strtotime($blog['created_at'])); ?>
        </time>
    </div>

    <div class="prose prose-emerald max-w-none mb-8 text-gray-800 leading-relaxed">
        <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
    </div>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $blog['user_id']): ?>
        <div class="flex gap-4 mt-6">
            <a href="blog_edit.php?id=<?php echo $blog['id']; ?>"
               class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150">
                ✏️ Edit
            </a>
            <a href="blog_delete.php?id=<?php echo $blog['id']; ?>"
               onclick="return confirm('Are you sure you want to delete this post?');"
               class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150">
                🗑️ Delete
            </a>
        </div>
    <?php endif; ?>

    <div class="mt-10">
        <a href="index.php"
           class="inline-block text-emerald-600 hover:text-emerald-700 font-medium transition duration-150">
            ← Back to all blogs
        </a>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
