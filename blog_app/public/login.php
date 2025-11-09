<?php
session_start();
require_once('../includes/db_connect.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errors[] = "Both fields are required.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: index.php');
                exit;
            } else {
                $errors[] = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            $errors[] = "Login failed: " . $e->getMessage();
        }
    }
}

include('../includes/header.php');
?>

<div class="flex items-center justify-center flex-grow py-12">
  <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
      <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">Welcome Back 👋</h2>

      <?php include('../includes/errors.php'); ?>

      <form method="POST">
          <div class="mb-5">
              <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
              <input type="email" id="email" name="email" required
                     class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
          </div>
          <div class="mb-6">
              <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
              <input type="password" id="password" name="password" required
                     class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
          </div>
          <button type="submit"
                  class="w-full text-white font-semibold py-3 rounded-xl transition duration-200 bg-emerald-600 hover:bg-emerald-700 shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
              Sign In
          </button>
          <div class="mt-6 text-center text-sm">
              <p class="text-gray-600">
                  Don’t have an account?
                  <a href="register.php" class="text-emerald-600 hover:text-emerald-700 font-medium">Register</a>
              </p>
          </div>
      </form>
  </div>
</div>

<?php include('../includes/footer.php'); ?>
