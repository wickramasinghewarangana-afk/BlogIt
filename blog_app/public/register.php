<?php
session_start();
require_once('../includes/db_connect.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);
            $_SESSION['message'] = "Registration successful! You can now login.";
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Registration failed: " . $e->getMessage();
        }
    }
}

include('../includes/header.php');
?>

<div class="flex items-center justify-center flex-grow py-12">
  <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
      <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">Create Your BlogIt Account</h2>

      <?php include('../includes/errors.php'); ?>

      <form method="POST">
          <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
              <input type="text" name="username" required
                     class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
          </div>
          <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
              <input type="email" name="email" required
                     class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
          </div>
          <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
              <input type="password" name="password" required
                     class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
          </div>
          <button type="submit"
                  class="w-full text-white font-semibold py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 shadow-lg focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
              Register
          </button>
          <div class="mt-6 text-center text-sm">
              <p class="text-gray-600">
                  Already have an account?
                  <a href="login.php" class="text-emerald-600 hover:text-emerald-700 font-medium">Login</a>
              </p>
          </div>
      </form>
  </div>
</div>

<?php include('../includes/footer.php'); ?>

