<?php
session_start();
require_once('../includes/db_connect.php');

try {
    $stmt = $pdo->query("SELECT blogpost.*, user.username FROM blogpost JOIN user ON blogpost.user_id = user.id ORDER BY blogpost.created_at DESC");
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error loading blogs: " . $e->getMessage());
}

include('../includes/header.php');
include('../includes/errors.php');
?>

<h1 class="text-4xl font-bold text-gray-900 mb-8 border-b pb-4">All Blogs</h1>

<?php if (isset($_SESSION['user_id'])): ?>
    <p class="mb-6 text-emerald-600 font-medium">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
<?php endif; ?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php if (count($blogs) > 0): ?>
        <?php foreach ($blogs as $blog): ?>
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden border border-gray-100">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">
                        <a href="blog_view.php?id=<?php echo $blog['id']; ?>" class="hover:text-emerald-600">
                            <?php echo htmlspecialchars($blog['title']); ?>
                        </a>
                    </h2>
                    <p class="text-gray-600 text-sm mb-4">
                        <?php echo nl2br(htmlspecialchars(substr($blog['content'], 0, 120))); ?>...
                    </p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>By <?php echo htmlspecialchars($blog['username']); ?></span>
                        <time><?php echo date("M d, Y", strtotime($blog['created_at'])); ?></time>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-500 text-center col-span-3">
            No blogs yet. <a href="blog_create.php" class="text-emerald-600 font-medium">Create one now!</a>
        </p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
