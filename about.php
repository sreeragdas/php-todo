<?php
session_start();
$appName = 'Modern Notes';
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Modern Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/notebook-2333053-1939355.png" alt="" width="35" height="35" class="d-inline-block align-top">
      <b class="ms-2">MODERN NOTES</b>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 200px;">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
      <?php if(!empty($_SESSION['user_id'])): ?>
        <div class="d-flex align-items-center text-white me-3">Hello, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></div>
        <a class="btn btn-outline-light me-2" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="btn btn-outline-light me-2" href="login.php">Login</a>
        <a class="btn btn-outline-success" href="register.php">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container mt-5">
  <h2>About <?php echo $appName; ?></h2>
  <p>Modern Notes is a simple, modern web application for managing your notes efficiently. Built with PHP and PostgreSQL/MySQL, it offers a clean interface and essential features for your productivity.</p>
  <ul>
    <li>Secure user authentication</li>
    <li>Easy note creation, editing, and deletion</li>
    <li>Responsive and modern design</li>
    <li>Open source and extensible</li>
  </ul>
</div>
</body>
</html>
