<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogIt</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ecfdf5;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background: #a7f3d0;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6ee7b7;
        }
    </style>
</head>
<body class="text-gray-800 antialiased flex flex-col min-h-screen bg-emerald-50">


<!-- Navbar -->
<header class="bg-white shadow sticky top-0 z-10 border-b border-emerald-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <a href="index.php" class="text-3xl font-extrabold text-emerald-700 tracking-tight">
            BlogIt
        </a>

        <nav class="flex items-center space-x-6">
            <a href="index.php" class="text-gray-600 hover:text-emerald-600 font-medium transition duration-150">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="blog_create.php" class="bg-emerald-600 text-white hover:bg-emerald-700 py-2 px-4 rounded-lg shadow-md transition duration-150">+ New Blog</a>
                <a href="logout.php" class="text-red-600 hover:text-red-700 font-medium">Logout</a>
            <?php else: ?>
                <a href="login.php" class="text-gray-600 hover:text-emerald-600 font-medium">Login</a>
                <a href="register.php" class="text-gray-600 hover:text-emerald-600 font-medium">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<!-- Page Container -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
