<?php
session_start();
require_once __DIR__ . '/auth_helper.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    if (!$email || !$pass) {
        $error = 'Email and password required.';
    } else {
        $user = find_user($email);
        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: index.php'); exit;
        } else {
            $error = 'Invalid credentials.';
        }
    }
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Sasti Notebook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light d-flex align-items-center" style="min-height:100vh;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-5">
          <div class="card shadow p-4 mt-5">
            <h2 class="mb-3 text-center">Login</h2>
            <?php if($error){ echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>'; } ?>
            <form method="POST" autocomplete="off">
              <div class="mb-3">
                <input class="form-control" name="email" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
              </div>
              <div class="mb-3">
                <input class="form-control" name="password" type="password" placeholder="Password" required>
              </div>
              <button class="btn btn-primary w-100" type="submit">Login</button>
            </form>
            <div class="mt-3 text-center">
              <a href="register.php">Create account</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
