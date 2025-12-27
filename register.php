<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/auth_helper.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    if (!$name || !$email || !$pass) {
        $errors[] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    } else {
       $user = find_user($email);
if ($user) {
    $errors[] = 'Email already registered.';
} else {
    $new_user_id = create_user($name, $email, $pass); // store returned ID
    if ($new_user_id && is_numeric($new_user_id)) {
      $_SESSION['user_id'] = $new_user_id;  // use new ID
      $_SESSION['user_name'] = $name;
      header('Location: index.php');
      exit;
    } else {
      $errors[] = 'Registration failed. Try again.';
    }
}
 

        }
          }
      
      ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register - Modern Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light d-flex align-items-center" style="min-height:100vh;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-5">
          <div class="card shadow p-4 mt-5">
            <h2 class="mb-3 text-center">Register</h2>
            <?php if(!empty($errors)){ echo '<div class="alert alert-danger">'.implode('<br>',$errors).'</div>'; } ?>
            <form method="POST" autocomplete="off">
              <div class="mb-3">
                <input class="form-control" name="name" placeholder="Full name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
              </div>
              <div class="mb-3">
                <input class="form-control" name="email" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
              </div>
              <div class="mb-3">
                <input class="form-control" name="password" type="password" placeholder="Password" required>
              </div>
              <button class="btn btn-primary w-100" type="submit">Create account</button>
            </form>
            <div class="mt-3 text-center">
              <a href="login.php">Already have an account? Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
